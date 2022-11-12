<?php

if (userConnected()) {
    $urls = $bdd->getUserUrls($_SESSION['user']);
}
else{
    header("Location: index.php?page=login");
}

// Delete
if (isset($_GET['delete'])) {
    $id = filter_input(INPUT_GET, 'delete');

    if(!$bdd->validateUrlOwner($id, $_SESSION['user'])){
        header("Location: index.php?page=profile");
        die();
    }

    $bdd->deleteUrlByID($id);
    unset($_GET['delete']);
    header('Location: index.php?page=profile');
}

// Update
if (isset($_GET['updateId']) && isset($_GET['updateActive'])) {
    $id = filter_input(INPUT_GET, 'updateId');
    $is_active = filter_input(INPUT_GET, 'updateActive');

    if(!$bdd->validateUrlOwner($id, $_SESSION['user'])){
        header("Location: index.php?page=profile");
        die();
    }

    $bdd->setActive($id, $is_active ? 0 : 1);
    unset($_GET['updateId']);
    unset($_GET['updateActive']);
    header('Location: index.php?page=profile');
}
