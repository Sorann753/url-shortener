<?php
if (!empty($_GET['file'])) {
    $filename = basename($_GET['file']);
    $filepath = 'uploads/' . $filename;
    if (!empty($filename) && file_exists($destination)) {

        //Define Headers
        header("Cache-Control: public");
        header("Content-Description: FIle Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/zip");
        header("Content-Transfer-Emcoding: binary");

        readfile($destination);
        exit;

    } else {
        echo "This File Does not exist.";
    }
}

?>