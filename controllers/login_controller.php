<?php

$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$password = filter_input(INPUT_POST, 'password');

if ($email && $password) {
    $user = $bdd->getUserByEmail($email);
    var_dump($user);
    if ($user) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user['email'];
            header("Location: /index.php?page=home");
            exit();
        }
        else {
            $error = "Wrong password";
        }
    }
    else {
        $error = "User not found";
    }
}