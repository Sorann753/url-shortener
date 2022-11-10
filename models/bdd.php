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

    public function getAllUsers(): array
    {
        $req = $this->pdo->prepare('SELECT * FROM users');
        $req->execute();
        $data = $req->fetchAll();
        $req->closeCursor();
        return $data;
    }

    public function getUserUrls($fk_user): array
    {
        $req = $this->pdo->prepare('SELECT * FROM url WHERE fk_user = ?');
        $req->execute(array($fk_user));
        $data = $req->fetchAll();
        $req->closeCursor();
        return $data;
    }
}
