<?php
if(isset($_SESSION['user'])){
    logEvent("LOGOUT", "User [" . $_SESSION['user'] . "] logged out", "index.php?page=logout");
    unset($_SESSION['user']);
    header('Location: index.php?page=home');
    exit();
}
else{
    header('Location: index.php?page=home');
    die();
}
