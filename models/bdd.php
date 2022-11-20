<?php

require ROOT_PATH . '/config/database.conf.php';

// interface for the database
class Bdd
{
    private ?PDO $pdo = NULL;

    public function __construct()
    {
        $this->pdo = getBdd();
    }

    public function __destruct()
    {
        $this->pdo = NULL;
    }

    /**
     * Get all the urls of a user from the database.
     * 
     * @param string $userEmail
     * @return array
     */
    public function getUserUrls($userEmail): array
    {
        $req = $this->pdo->prepare(<<<EOL
            SELECT url.*
            FROM url, users
            WHERE users.email = ?
            AND url.fk_user = users.id
        EOL);
        $req->execute(array($userEmail));
        $data = $req->fetchAll(PDO::FETCH_OBJ);
        $req->closeCursor();
        return $data;
    }

    /**
     * Add a user in the database.
     *
     * @param string $email
     * @param string $password a hashed password
     * @param string $username
     * @return boolean TRUE on success or FALSE on failure.
     */
    public function addUser($email, $password, $username): bool
    {
        $req = $this->pdo->prepare("INSERT INTO users (email, username, password) VALUES (?, ?, ?)");
        $req->execute(array($email, $username, $password));
        return $req->closeCursor();
    }

    /**
     * Get the id of the user from his email.
     *
     * @param string $email
     * @return int
     */
    public function getUserIdByEmail($email): int
    {
        $req = $this->pdo->prepare('SELECT * FROM users WHERE email = ?');
        $req->execute(array($email));
        $req->bindColumn('id', $id);
        $req->fetch(PDO::FETCH_BOUND);
        $req->closeCursor();
        return $id;
    }

    /**
     * Get a user from his email or username.
     *
     * @param string $username
     * @return stdClass or False in case of failure
     */
    public function getUserByEmailOrUsername($username)
    {
        $req = $this->pdo->prepare('SELECT * FROM users WHERE email = ? OR username = ?');
        $req->execute(array($username, $username));
        $data = $req->fetch(PDO::FETCH_OBJ);
        $req->closeCursor();
        return $data;
    }

    /**
     * Get a username from the email of a user.
     *
     * @param string $email
     * @return string or False in case of failure
     */
    public function getUsernameByEmail($email)
    {
        $req = $this->pdo->prepare('SELECT username FROM users WHERE email = ?');
        $req->execute(array($email));
        $req->bindColumn('username', $username);
        $req->fetch(PDO::FETCH_BOUND);
        $req->closeCursor();
        return $username;
    }

    /**
     * Get the url pointed by a short url
     * 
     * @param string $shortUrl
     * @return string or False in case of failure
     */
    public function getUrlByShortUrl($shortUrl)
    {
        $req = $this->pdo->prepare('SELECT url FROM url WHERE short_url = ? AND is_active = 1');
        $req->execute(array($shortUrl));
        $req->bindColumn('url', $url);
        $req->fetch(PDO::FETCH_BOUND);
        $req->closeCursor();
        return $url;
    }

    /**
     * Add a new url to the database.
     *
     * @param string $url
     * @param string $short_url
     * @param string $userEmail
     * @param bool $isFile
     * @param int $nbClick
     * @param bool $isActive
     * @return boolean TRUE on success or FALSE on failure.
     */
    public function addUrl($url, $shortUrl, $userEmail, $isFile = false, $nbClick = 0, $is_active = true): bool
    {
        $fk_user = $this->getUserIdByEmail($userEmail);
        $req = $this->pdo->prepare("INSERT INTO url (url, short_url, nb_click, is_active, is_file, fk_user) VALUES (?, ?, ?, ?, ?, ?)");
        $req->execute(array($url, $shortUrl, $nbClick, $is_active, $isFile ? 1 : 0, $fk_user));
        return $req->closeCursor();
    }

    /**
     * Delete a user from his email.
     *
     * @param string $email
     * @return boolean TRUE on success or FALSE on failure.
     */
    public function deleteUserByEmail($email): bool
    {
        $req = $this->pdo->prepare('DELETE FROM users WHERE email = ?');
        $req->execute(array($email));
        return $req->closeCursor();
    }

    /**
     * Delete a url from his id
     *
     * @param int $urlId
     * @return boolean TRUE on success or FALSE on failure.
     */
    public function deleteUrlByID($urlId): bool
    {
        $req = $this->pdo->prepare('DELETE FROM url WHERE id = ?');
        $req->execute(array($urlId));
        return $req->closeCursor();
    }

    /**
     * Set wether a url is active or not
     *
     * @param int $urlId
     * @param int $isActive
     * @return boolean TRUE on success or FALSE on failure.
     */
    public function setActive($urlId, $isActive): bool
    {
        $req = $this->pdo->prepare('UPDATE url SET is_active = ? WHERE id = ?');
        $req->execute(array($isActive, $urlId));
        return $req->closeCursor();
    }

    /**
     * Check that a user is the owner of a url
     * 
     * @param string $urlId
     * @param string $userEmail
     * @return boolean TRUE if the user is the owner of the url, FALSE if not.
     */
    public function validateUrlOwner($urlId, $userEmail): bool
    {
        $req = $this->pdo->prepare(<<<EOL
            SELECT users.*
            FROM url, users
            WHERE url.id = ?
            AND users.email = ?
            AND url.fk_user = users.id
        EOL);
        $req->execute(array($urlId, $userEmail));
        $data = $req->fetch(PDO::FETCH_OBJ);
        $req->closeCursor();
        return $data != NULL;
    }

    /**
     * increment the number of click on a url
     * 
     * @param string $shortUrl
     * @return boolean TRUE on success or FALSE on failure.
     */
    public function incrementUrlClickNumber($shortUrl)
    {
        $req = $this->pdo->prepare('UPDATE url SET nb_click = nb_click + 1 WHERE short_url = ?');
        $req->execute(array($shortUrl));
        return $req->closeCursor();
    }

    /**
     * Check if a short url is pointing to a file
     *
     * @param string $short_url
     * @return boolean TRUE if the url is pointing to a file, FALSE if not.
     */
    public function isFile($shortUrl)
    {
        $req = $this->pdo->prepare('SELECT is_file FROM url WHERE short_url = ?');
        $req->execute(array($shortUrl));
        $req->bindColumn('is_file', $isFile, PDO::PARAM_BOOL);
        $req->fetch(PDO::FETCH_BOUND);
        $req->closeCursor();
        return $isFile;
    }

    /**
     * Return a url object from its id.
     *
     * @param int $id
     * @return stdClass or False in case of failure
     */
    public function getUrlById($id)
    {
        $req = $this->pdo->prepare('SELECT * FROM url WHERE id = ?');
        $req->execute(array($id));
        $data = $req->fetch(PDO::FETCH_OBJ);
        $req->closeCursor();
        return $data;
    }
}
