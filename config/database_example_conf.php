<?php

// pour faire fonctionner le site, il faut renommer ce fichier en database.conf.php

function getBdd(): PDO
{
    $user = 'username';
    $pass = 'password';

    $engine = 'Your engine';
    $host = 'Your host';
    $port = 'The port of the database (MariaDB, InnoDB, ...)';
    $dbname = 'The name of your DB';
    $charset = 'the charset of your DB';

    $dsn = "$engine:host=$host:$port;dbname=$dbname;charset=$charset";

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        $bdd = new PDO($dsn, $user, $pass, $options);
    } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int)$e->getCode());
    }

    return $bdd;
}