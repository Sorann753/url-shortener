<?php
// if ($_SERVER["REQUEST_METHOD"] !== "POST") {
//   exit("POST request method required");
// }

// TODO : integrate upload.php and download.php into the MVC architecture (see home_controller.php for example)
// creating an upload page (upload_controller and upload_view) would be a good idea

if (empty($_FILES)) {
    exit('$_FILES is empty - is file_uploads enabled in php.ini ?');
}

if ($_FILES["file"]["error"] !== UPLOAD_ERR_OK) {

    switch ($_FILES["file"]["error"]) {
        case UPLOAD_ERR_PARTIAL:
            exit('File only partially uploaded');
        break;

        case UPLOAD_ERR_NO_FILE:
            exit('No file was uploaded');
        break;

        case UPLOAD_ERR_EXTENSION:
            exit('File upload stopped by a PHP extension');
        break;

        case UPLOAD_ERR_FORM_SIZE:
            exit('File exceeds MAX_FILE_SIZE in the HTML form');
        break;

        case UPLOAD_ERR_INI_SIZE:
            exit('File exceeds upload_max_filesize in php.ini');
        break;

        case UPLOAD_ERR_NO_TMP_DIR:
            exit('Temporary folder not found');
        break;

        case UPLOAD_ERR_CANT_WRITE:
            exit('Failed to write file');
        break;

        default:
            exit('Unknown upload error');
    }
}

define('MAX_FILE_SIZE', 12000000); // 12MB

if ($_FILES["file"]["size"] > MAX_FILE_SIZE) {
    exit('File too large (max 12MB)');
}

$pathinfo = pathinfo($_FILES["file"]["name"]);

$base = $pathinfo["filename"];

$base = preg_replace("/[^\w-]/", "_", $base);

$filename = $base . "." . $pathinfo["extension"];

$data = $_FILES["file"];
$destination = __DIR__ . "/../uploads/" . $data["name"];

$i = 1;
while (file_exists($destination)) {

    $filename = $base . "($i)." . $pathinfo["extension"];
    $destination = __DIR__ . "/../uploads/" . $filename;

    $i++;
}

if (!move_uploaded_file($_FILES["file"]["tmp_name"], $destination)) {

    exit("Can't move uploaded file");
}

echo "Filed Upload Perfectly !" ?> </br>

<!-- Pour telecharger wsh -->
<a href="download.php?file=?">Telecharger</a>