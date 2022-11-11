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
     * Function which return all the users from the database.
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
     * Function which return all the urls of a user from the database.
     * @param int $fk_user
     *
     * @return array
     */
    public function getUserUrls($fk_user): array
    {
        $req = $this->pdo->prepare('SELECT * FROM url WHERE fk_user = ?');
        $req->execute(array($fk_user));
        $data = $req->fetchAll();
        $req->closeCursor();
        return $data;
    }

    /**
     * Function which add a user in the database.
     *
     * @param string $email
     * @param string $password
     * @return boolean
     */
    public function addUser($email, $password): bool
    {
        $req = $this->pdo->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
        $req->execute(array($email, $password));
        return $req->closeCursor();
    }

    /**
     * Function which return a user thanks to his email.
     *
     * @param string $email
     * @return array
     */
    public function getUserByEmail($email): array
    {
        $req = $this->pdo->prepare('SELECT * FROM users WHERE email = ?');
        $req->execute(array($email));
        $data = $req->fetchAll();
        $req->closeCursor();
        return $data;
    }

    public function getUrlByShortUrl($short_url): array
    {
        $req = $this->pdo->prepare('SELECT * FROM url WHERE short_url = ?');
        $req->execute(array($short_url));
        $data = $req->fetchAll();
        $req->closeCursor();
        return $data;
    }

    /**
     * Function which add an url in the database.
     *
     * @param string $url
     * @param string $short_url
     * @param int $nb_click
     * @param bool $is_active
     * @param int $fk_user
     * @return boolean
     */
    public function addUrl($url, $short_url, $nb_click, $is_active, $fk_user): bool
    {
        $req = $this->pdo->prepare("INSERT INTO url (url, short_url, nb_click, is_active, fk_user) VALUES (?, ?, ?, ?, ?)");
        $req->execute(array($url, $short_url, $nb_click, $is_active, $fk_user));
        return $req->closeCursor();
    }

    /**
     * Function which delete an user.
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
     * Function which delete an url.
     *
     * @param int $id
     * @return boolean
     */
    public function deleteUrlByID($id): bool
    {
        $req = $this->pdo->prepare('DELETE FROM url WHERE id = ?');
        $req->execute(array($id));
        return $req->closeCursor();
    }
}
