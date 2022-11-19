<?php

if (userConnected()) {
    $urls = $bdd->getUserUrls($_SESSION['user']);
} else {
    header("Location: index.php?page=login");
}

// Delete
if (isset($_GET['delete'])) {
    $id = filter_input(INPUT_GET, 'delete');

    if (!$bdd->validateUrlOwner($id, $_SESSION['user'])) {
        header("Location: index.php?page=profile");
        die();
    }

    $url = $bdd->getUrlById($id);
    if ($bdd->isFile($url->short_url)) {
        if (unlink(UPLOAD_PATH . '/' . $url->url)) {
            logEvent("FILE DELETED", "file: $url->url deleted", "index.php?page=profile");
        } else {
            logEvent("CRITICAL ERROR", "Error when deleting file", "index.php?page=profile", LOG_LVL_CRITICAL);
        }
    }


    $bdd->deleteUrlByID($id);
    unset($_GET['delete']);
    header('Location: index.php?page=profile');
}

// Update
if (isset($_GET['updateId']) && isset($_GET['updateActive'])) {
    $id = filter_input(INPUT_GET, 'updateId');
    $is_active = filter_input(INPUT_GET, 'updateActive');

    if (!$bdd->validateUrlOwner($id, $_SESSION['user'])) {
        header("Location: index.php?page=profile");
        die();
    }

    $bdd->setActive($id, $is_active ? 0 : 1);
    unset($_GET['updateId']);
    unset($_GET['updateActive']);
    header('Location: index.php?page=profile');
}
