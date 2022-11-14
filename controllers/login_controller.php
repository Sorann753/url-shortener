<?php

$username = filter_input(INPUT_POST, 'username');
$password = filter_input(INPUT_POST, 'password');

if ($username && $password) {
    $user = $bdd->getUserByEmailOrUsername($username);
    if ($user) {
        if (password_verify($password, $user->password)) {
            $_SESSION['user'] = $user->email;
            header("Location: index.php?page=home");
            exit();
        } else {
            $error = "Wrong password";
        }
    } else {
        $error = "Wrong credentials";
    }
}
