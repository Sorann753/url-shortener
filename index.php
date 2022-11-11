<?php
session_start();

require_once './config/const.php';
require ROOT_PATH . '/models/bdd.php';
require ROOT_PATH . '/includes/utils.php';

$bdd = new Bdd();

$page = filter_input(INPUT_GET, 'page');
$shortUrl = filter_input(INPUT_GET, 'url');

if($shortUrl){
    $trueUrl = $bdd->getUrlByShortUrl($shortUrl);
    if($trueUrl){
        header('Location: ' . $trueUrl);
        exit();
    }
    else{
        header("Location: /index.php?page=home");
        exit();
    }
}

if (! $page) {
    $page = 'home';
}

$allPages = scandir(ROOT_PATH . '/controllers/');

if (in_array($page . '_controller.php', $allPages)) {
    require (ROOT_PATH . '/controllers/' . $page . '_controller.php');
    require (ROOT_PATH . '/views/' . $page . '_view.php');
}
else {
    header("Location: /index.php?page=home");
    exit();
}