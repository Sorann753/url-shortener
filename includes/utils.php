<?php

/**
 * generate a shortened version of an url and add it to the database
 * @param string $url
 * @return string
 */
function shortenUrl(string $url): array
{
    $key = base64_encode(random_bytes(10));
    $shortUrl = $_SERVER['SERVER_NAME'] . "/index?url=$key";

    // TODO: save the key and the original url in the database

    return [$shortUrl, $key];
}
