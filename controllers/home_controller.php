<?php

$url = filter_input(INPUT_POST, 'url', FILTER_SANITIZE_URL);

if ($url) {
    $shortUrl = makeShortUrl();

    if (userConnected()) {
        for ($nb_try = 0; $nb_try < 10; $nb_try++) {
            try {
                $urlAdded = $bdd->addUrl($url, $shortUrl["key"], $_SESSION['user']);
                break;
            } catch (PDOException $e) {
                $shortUrl = makeShortUrl();
            }
        }

        if ($urlAdded) {
            $newShortUrl = $shortUrl["full"];
        } else {
            $error = "Something went wrong, your url could not be created";
        }
    }
}
