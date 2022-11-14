<?php
unset($_SESSION['temporaryUrl']);
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
    } else {
        // Cas où pas pas connecté :
        $newShortUrl = $shortUrl["full"];
        $_SESSION['temporaryUrl'] = $url;
    }
}
