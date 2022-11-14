<?php

$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$password = filter_input(INPUT_POST, 'password');
$username = filter_input(INPUT_POST, 'username');

if ($email && $password) {
    // create the new account
    $password = password_hash($password, PASSWORD_DEFAULT);
    $user = $bdd->addUser($email, $password, $username);
    if ($user) {
        $_SESSION['user'] = $user['email'];
        header("Location: index.php?page=home");
        exit();
    }
    else {
        $error = "Email invalid or already used";
    }

}
