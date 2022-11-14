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
    header("Location: error.php?error=" . urlencode($e->getMessage()) . "&page=$page");
    die("[CRITICAL ERROR] " . $e->getMessage());
}

if ($shortUrl) {
    $trueUrl = $bdd->getUrlByShortUrl($shortUrl);
    if ($trueUrl) {
        $bdd->incrementUrlClickNumber($shortUrl);
        http_response_code(302);
        header('Location: ' . $trueUrl);
        exit();
    } else {
        header("Location: index.php?page=home");
        die();
    }
}

$allPages = scandir(ROOT_PATH . '/controllers/');

if (in_array($page . '_controller.php', $allPages)) {
    require(ROOT_PATH . '/controllers/' . $page . '_controller.php');
    require(ROOT_PATH . '/views/' . $page . '_view.php');
} else {
    header("Location: index.php?page=home");
    die();
}
