<?php

/**
 * generate a random short url
 * @param none
 * @return string
 */
function makeShortUrl(): array
{
    $key = base64_encode(random_bytes(10));
    $shortUrl = BASE_URL . "?url=$key";

    return [$shortUrl, $key];
}

/**
 * check if the user is connected
 * @param none
 * @return bool
 */
function userConnected(): bool
{
    return isset($_SESSION['user']);
}
