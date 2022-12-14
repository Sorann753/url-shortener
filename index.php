<?php
ini_set('session.gc_maxlifetime', 28800);
session_set_cookie_params(28800);
session_start();

require_once './config/const.php';
require ROOT_PATH . '/models/bdd.php';
require ROOT_PATH . '/includes/utils.php';

$page = filter_input(INPUT_GET, 'page');
$shortUrl = filter_input(INPUT_GET, 'url');

if (!$page) {
    $page = 'home';
}

try {
    $bdd = new Bdd();
} catch (PDOException $e) {
    header("Location: error.php");
    logEvent("CRITICAL ERROR", $e->getMessage(), "index.php?page=$page", LOG_LVL_CRITICAL);
    die();
}

if ($shortUrl) {
    $trueUrl = $bdd->getUrlByShortUrl($shortUrl);
    if ($trueUrl) {
        $bdd->incrementUrlClickNumber($shortUrl);
        if ($bdd->isFile($shortUrl)) {
            if (file_exists(UPLOAD_PATH) && is_readable(UPLOAD_PATH)) {
                $size = filesize(UPLOAD_PATH);
                // Sent the headers
                header('Content-Type: ' . mime_content_type(UPLOAD_PATH));
                header('Content-Length: ' . $size);
                header('Content-Disposition: attachment; filename=' . $trueUrl);
                header('Content-Transfer-Encoding: binary');
                // Open the file in binary read-only mode
                $file = @fopen(UPLOAD_PATH, 'rb');

                if ($file) {
                    fpassthru($file);
                    logEvent("DOWNLOAD", "?url=$shortUrl <=> $trueUrl", "index.php");
                } else {
                    logEvent("CRITICAL ERROR", "Error when downloading", "index.php?page=$page", LOG_LVL_CRITICAL);
                }
            } else {
                logEvent("CRITICAL ERROR", "Error when downloading", "index.php?page=$page", LOG_LVL_CRITICAL);
            }
        } else {
            logEvent("REDIRECT", "?url=$shortUrl <=> $trueUrl", "index.php");
            http_response_code(302);
            header('Location: ' . $trueUrl);
            exit();
        }
    } elseif (isset($_SESSION['temporaryUrl'])) {
        logEvent("ANON-REDIRECT", "?url=$shortUrl <=> " . $_SESSION['temporaryUrl'], "index.php", LOG_LVL_DEBUG);
        http_response_code(302);
        header('Location: ' . $_SESSION['temporaryUrl']);
        unset($_SESSION['temporaryUrl']);
        die();
    } else {
        logEvent("REDIRECT-404", "URL not found", "index.php?url=$shortUrl", LOG_LVL_VERBOSE);
        header("Location: index.php?page=home");
        die();
    }
}

$allPages = scandir(ROOT_PATH . '/controllers/');

if (in_array($page . '_controller.php', $allPages)) {
    logEvent('GET', "?page=$page", "index.php");
    require(ROOT_PATH . '/controllers/' . $page . '_controller.php');
    require(ROOT_PATH . '/views/' . $page . '_view.php');
} else {
    logEvent('GET', "?page=home", "index.php");
    header("Location: index.php?page=home");
    die();
}
