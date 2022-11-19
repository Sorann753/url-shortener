<?php

$username = filter_input(INPUT_POST, 'username');
$password = filter_input(INPUT_POST, 'password');

if ($username && $password) {
    $user = $bdd->getUserByEmailOrUsername($username);
    if ($user) {
        if (password_verify($password, $user->password)) {
            $_SESSION['user'] = $user->email;
            logEvent("LOGIN", "User $username logged in", "index.php?page=login");
            header("Location: index.php?page=home");
            exit();
        } else {
            logEvent("LOGIN-ERR", "User [" . $_SESSION['user'] . "] failed to log in, wrong password", "index.php?page=login", LOG_LVL_DEBUG);
            $error = "Wrong password";
        }
    } else {
        logEvent("LOGIN-ERR", "User [" . $_SESSION['user'] . "] failed to log in, user not found", "index.php?page=login", LOG_LVL_DEBUG);
        $error = "Wrong credentials";
    }
}
