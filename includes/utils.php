<?php

/**
 * generate a random short url
 * @param none
 * @return string
 */
function makeShortUrl(): array
{
    $key = base64_encode(random_bytes(10));
    $key = str_replace(['+', '/'], '#', $key);
    $shortUrl = BASE_URL . "?url=$key";

    return ["full" => $shortUrl, "key" => $key];
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



/**
 * log an event in the log file
 * @param string $type
 * @param string $message
 * @param string $origin
 * @param int $level (1:CRITICAL, 2:ERROR, 3:INFO, 4:DEBUG, 5:VERBOSE)
 * @return bool true if the log was written, false otherwise
 */
function logEvent(string $type, string $message, string $origin = "", int $level = LOG_LVL_INFO): bool
{
    if ($level > LOG_LEVEL) {
        return false;
    }

    //if the file doesn't exist, create it
    if (!file_exists(LOG_FILE)) {
        $newLogFile = fopen(LOG_FILE, "w");

        if (!$newLogFile) {
            return false;
        }

        //write the header line
        fwrite(
            $newLogFile,
            $_SERVER['SERVER_SOFTWARE'] . " - " . BASE_URL . PHP_EOL .
                "Date - Type - User - Message - Origin" . PHP_EOL
        );
        fclose($newLogFile);
    }

    $logFile = fopen(LOG_FILE, 'a');

    if (!$logFile) {
        return false;
    }

    $user = userConnected() ? $_SESSION['user'] : "Anonymous";
    $message = trim(preg_replace('/\s+/', ' ', $message));
    $type = strtoupper($type);

    fwrite($logFile, date('Y-m-d H:i:s') . " - [$type] - $user - $message - $origin" . PHP_EOL);
    fclose($logFile);

    return true;
}
