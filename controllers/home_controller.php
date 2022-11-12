<?php
$error;

$url = filter_input(INPUT_POST, 'url', FILTER_SANITIZE_URL);

if ($url) {
    $shortUrl = makeShortUrl();

    if (userConnected()) {
        try {
            // TODO: catch l'excepion qui est throw si l'url existe déjà et réessayer avec un autre short_url jusqu'à ce que ça marche
            $urlAdded = $bdd->addUrl($url, $shortUrl[1], $_SESSION['user']);
            if ($urlAdded) {
                $newShortUrl = $shortUrl[0];
            } else {
                $error = "Url not added";
            }
        } catch (PDOException $e) {
            $error = $e->getMessage();
        }
    } else {
        $urlAdded = $bdd->addUrl($url, $shortUrl, "test");
        if ($urlAdded) {
            $newShortUrl = $shortUrl;
            echo $newShortUrl;
        } else {
            $error = "Url not added";
        }
    }
}
