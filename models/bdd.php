<?php

require ROOT_PATH . '/config/database.conf.php';

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
     * Get all the users from the database.
     *
     * @return array
     */
    public function getAllUsers(): array
    {
        $req = $this->pdo->prepare('SELECT * FROM users');
        $req->execute();
        $data = $req->fetchAll();
        $req->closeCursor();
        return $data;
    }

    /**
     * Get all the urls of a user from the database.
     * 
     * @param string $userEmail
     * @return array
     */
    public function getUserUrls($userEmail): array
    {
        // $fk_user = $this->getUserIdByEmail($userEmail);
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
     * @return boolean TRUE on success or FALSE on failure.
     */
    public function addUser($email, $password): bool
    {
        $req = $this->pdo->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
        $req->execute(array($email, $password));
        return $req->closeCursor();
    }

    /**
     * Get the id of the user thanks to his email.
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
     * Get a user thanks to his email.
     *
     * @param string $email
     * @return stdClass
     */
    public function getUserByEmail($email)
    {
        $req = $this->pdo->prepare('SELECT * FROM users WHERE email = ?');
        $req->execute(array($email));
        $data = $req->fetch(PDO::FETCH_OBJ);
        $req->closeCursor();
        return $data;
    }

    /**
     * Get the url pointed by the short url
     * 
     * @param string $shortUrl
     * @return string
     */
    public function getUrlByShortUrl($short_url)
    {
        $req = $this->pdo->prepare('SELECT url FROM url WHERE short_url = ?');
        $req->execute(array($short_url));
        $req->bindColumn('url', $url);
        $req->fetch(PDO::FETCH_BOUND);
        $req->closeCursor();
        return $url;
    }

    /**
     * Add a url to the database.
     *
     * @param string $url
     * @param string $short_url
     * @param string $userEmail
     * @param int $nb_click
     * @param bool $is_active
     * @return boolean
     */
    public function addUrl($url, $short_url, $userEmail, $nb_click = 0, $is_active = true): bool
    {
        $fk_user = $this->getUserIdByEmail($userEmail);
        $req = $this->pdo->prepare("INSERT INTO url (url, short_url, nb_click, is_active, fk_user) VALUES (?, ?, ?, ?, ?)");
        $req->execute(array($url, $short_url, $nb_click, $is_active, $fk_user));
        return $req->closeCursor();
    }

    /**
     * Delete a user.
     *
     * @param int $id
     * @return boolean
     */
    public function deleteUserByID($id): bool
    {
        $req = $this->pdo->prepare('DELETE FROM users WHERE id = ?');
        $req->execute(array($id));
        return $req->closeCursor();
    }

    /**
     * Delete a url.
     *
     * @param int $urlId
     * @return boolean
     */
    public function deleteUrlByID($urlId): bool
    {
        $req = $this->pdo->prepare('DELETE FROM url WHERE id = ?');
        $req->execute(array($urlId));
        return $req->closeCursor();
    }

    /**
     * Set wether url is active or not
     *
     * @param int $urlId
     * @param int $is_active
     * @return boolean
     */
    function setActive($urlId, $is_active): bool
    {
        $req = $this->pdo->prepare('UPDATE url SET is_active = ? WHERE id = ?');
        $req->execute(array($is_active, $urlId));
        return $req->closeCursor();
    }

    /**
     * Check that a user is the owner of a url
     * 
     * @param string $urlId
     * @param string $userEmail
     * @return boolean
     */
    function validateUrlOwner($urlId, $userEmail): bool
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
}
