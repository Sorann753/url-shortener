<?php
unset($_SESSION['temporaryUrl']);
$url = filter_input(INPUT_POST, 'url', FILTER_SANITIZE_URL);

if ($url) {
    logEvent('POST', "url=$url", "home_controller.php", LOG_LVL_VERBOSE);
    $shortUrl = makeShortUrl();

    if (userConnected()) {
        for ($nb_try = 0; $nb_try < 10; $nb_try++) {
            try {
                $urlAdded = $bdd->addUrl($url, $shortUrl["key"], $_SESSION['user']);
                break;
            } catch (PDOException $e) {
                logEvent("ERROR", $e->getMessage(), "home_controller.php", LOG_LVL_ERROR);
                $shortUrl = makeShortUrl();
            }
        }

        if ($urlAdded) {
            $newShortUrl = $shortUrl["full"];
            logEvent("URL-ADDED", "$newShortUrl <=> $url", "index.php?page=home");
        } else {
            logEvent("ERROR", "URL not added", "index.php?page=home", LOG_LVL_ERROR);
            $error = "Something went wrong, your url could not be created";
        }
    } else {
        // Cas où pas connecté :
        $newShortUrl = $shortUrl["full"];
        $_SESSION['temporaryUrl'] = $url;
        logEvent("TMP-URL-ADDED", "$newShortUrl <=> $url", "index.php?page=home", LOG_LVL_DEBUG);
    }
}
