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
            die();
        }
    } else {
        // Case where not connected :
        $newShortUrl = $shortUrl["full"];
        $_SESSION['temporaryUrl'] = $url;
        logEvent("TMP-URL-ADDED", "$newShortUrl <=> $url", "index.php?page=home", LOG_LVL_DEBUG);
    }
} elseif (isset($_FILES['file'])) {
    switch ($_FILES["file"]["error"]) {
        case UPLOAD_ERR_PARTIAL:
            logEvent("ERROR", "File only partially uploaded", "index.php?page=home", LOG_LVL_ERROR);
            $error = "Something went wrong, your file could not be uploaded";
            break;

        case UPLOAD_ERR_NO_FILE:
            logEvent("ERROR", "No file was uploaded", "index.php?page=home", LOG_LVL_ERROR);
            $error = "Something went wrong, your file could not be uploaded";
            break;

        case UPLOAD_ERR_EXTENSION:
            logEvent("ERROR", "File upload stopped by a PHP extension", "index.php?page=home", LOG_LVL_ERROR);
            $error = "Something went wrong, your file could not be uploaded";
            break;

        case UPLOAD_ERR_FORM_SIZE:
            logEvent("ERROR", "File exceeds MAX_FILE_SIZE in the HTML form", "index.php?page=home", LOG_LVL_ERROR);
            $error = "Something went wrong, your file could not be uploaded";
            break;

        case UPLOAD_ERR_INI_SIZE:
            logEvent("ERROR", "File exceeds upload_max_filesize in php.ini", "index.php?page=home", LOG_LVL_ERROR);
            $error = "Something went wrong, your file could not be uploaded";
            break;

        case UPLOAD_ERR_NO_TMP_DIR:
            logEvent("ERROR", "Temporary folder not found", "index.php?page=home", LOG_LVL_ERROR);
            $error = "Something went wrong, your file could not be uploaded";
            break;

        case UPLOAD_ERR_CANT_WRITE:
            logEvent("ERROR", "Failed to write file", "index.php?page=home", LOG_LVL_ERROR);
            $error = "Something went wrong, your file could not be uploaded";
            break;

        default:
            logEvent("ERROR", "Unknown upload error", "index.php?page=home", LOG_LVL_ERROR);
            $error = "Something went wrong, your file could not be uploaded";
            break;

        case UPLOAD_ERR_OK:
            if (userConnected()) {
                $filename = $_FILES['file']['name'];
                logEvent('POST', "filename=$filename", "home_controller.php", LOG_LVL_VERBOSE);

                // Check uploaded file size :
                if ($_FILES['file']['size']  ===  0 || $_FILES['file']['size'] >= MAX_FILE_SIZE) {
                    logEvent("ERROR", "File size not respected", "index.php?page=home", LOG_LVL_ERROR);
                    $error = "Something went wrong, your file could not be uploaded";
                    exit();
                }

                // Check if file being is allowed :
                $forbiddenFileTypes = [
                    'image/svg+xml',
                    'text/javascript',
                    'application/octet-stream',
                    'application/x-httpd-php',
                    'application/x-sh',
                    'font/ttf'
                ];

                if (in_array($_FILES['file']['type'],  $forbiddenFileTypes)) {
                    logEvent("ERROR", "File with unauthorized format", "index.php?page=home", LOG_LVL_ERROR);
                    $error = "Something went wrong, your file could not be uploaded";
                    die();
                }

                //  Check if this is a valid upload :
                if (!is_uploaded_file($_FILES['file']['tmp_name'])) {
                    logEvent("ERROR", "File not valid", "index.php?page=home", LOG_LVL_ERROR);
                    $error = "Something went wrong, your file could not be uploaded";
                    die();
                }

                // Set the name of the directory to save the file being uploaded :
                $uploadDir  =  ROOT_PATH . '/uploads/';
                if (!move_uploaded_file($_FILES['file']['tmp_name'],  $uploadDir  .  $filename)) {
                    logEvent("ERROR", "Cannot copy uploaded file", "index.php?page=home", LOG_LVL_ERROR);
                    $error = "Something went wrong, your file could not be uploaded";
                    die();
                }

                // All's good ! Create the shortened url :
                $shortUrl = makeShortUrl();

                for ($nb_try = 0; $nb_try < 10; $nb_try++) {
                    try {
                        $urlAdded = $bdd->addUrl($filename, $shortUrl["key"], $_SESSION['user'], true);
                        break;
                    } catch (PDOException $e) {
                        logEvent("ERROR", $e->getMessage(), "home_controller.php", LOG_LVL_ERROR);
                        $shortUrl = makeShortUrl();
                    }
                }

                if ($urlAdded) {
                    $newShortUrl = $shortUrl["full"];
                    logEvent("URL-ADDED", "$newShortUrl <=> $filename", "index.php?page=home");
                } else {
                    logEvent("ERROR", "URL not added", "index.php?page=home", LOG_LVL_ERROR);
                    $error = "Something went wrong, your url could not be created";
                    die();
                }
            } else {
                $error = "To use the full potential of this website, you need to login / signup into your account.";
            }
            break;
    }
}
