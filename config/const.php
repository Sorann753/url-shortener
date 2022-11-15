<?php
$server = $_SERVER['SERVER_SOFTWARE'];
if (strpos($server, 'nginx')) {
    define('BASE_URL', $_SERVER['SERVER_NAME'] . '/url-shortener');
} else {
    define('BASE_URL', 'http://localhost/url-shortener');
}
define('ROOT_PATH', realpath($_SERVER['DOCUMENT_ROOT'] . '/url-shortener'));

define('LOG_FILE', ROOT_PATH . "/logs/log-" . date('Y-m-d') . ".log");
define('LOG_LVL_CRITICAL', 1);
define('LOG_LVL_ERROR', 2);
define('LOG_LVL_INFO', 3); // enum from php 8.1 would be better but i'm currently coding in php 7.4
define('LOG_LVL_DEBUG', 4);
define('LOG_LVL_VERBOSE', 5);
define('LOG_LEVEL', LOG_LVL_INFO);
