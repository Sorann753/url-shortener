<?php

if (userConnected()) {
    $fk = $bdd->getUserIdByEmail($_SESSION['user']);
    $urls = $bdd->getUserUrls($fk);
}

// Delete
if (isset($_GET['delete'])) {
    $id = filter_input(INPUT_GET, 'delete');
    $bdd->deleteUrlByID($id);
    unset($_GET['delete']);
    header('Location: /index.php?page=profile');
}

// Update
if (isset($_GET['updateId']) && isset($_GET['updateActive'])) {
    $id = filter_input(INPUT_GET, 'updateId');
    $is_active = filter_input(INPUT_GET, 'updateActive');
    $bdd->setActive($id, $is_active ? 0 : 1);
    unset($_GET['updateId']);
    unset($_GET['updateActive']);
    header('Location: /index.php?page=profile');
}
