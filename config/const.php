<?php
$server = $_SERVER['SERVER_SOFTWARE'];
if (strpos($server, 'nginx')) {
    define('BASE_URL', $_SERVER['SERVER_NAME'] . '/url-shortener');
} else {
    define('BASE_URL', 'http://localhost/url-shortener');
}
define('ROOT_PATH', realpath($_SERVER['DOCUMENT_ROOT'] . '/url-shortener'));
