<?php

if (userConnected()) {
    $urls = $bdd->getUserUrls($_SESSION['user']);
} else {
    logEvent("DENIED", "unconected user trying to access profile page", "index.php?page=profile", LOG_LVL_VERBOSE);
    header("Location: index.php?page=login");
    die();
}

// Delete
$deleteId = filter_input(INPUT_GET, 'delete', FILTER_VALIDATE_INT);
if ($deleteId) {

    if (!$bdd->validateUrlOwner($deleteId, $_SESSION['user'])) {
        logEvent("DENIED", "User [" . $_SESSION['user'] . "] tried to delete url [$deleteId] but is not the owner", "index.php?page=profile", LOG_LVL_CRITICAL);
        header("Location: index.php?page=profile");
        die();
    }

    $url = $bdd->getUrlById($deleteId);
    if ($bdd->isFile($url->short_url)) {
        if (unlink(UPLOAD_PATH . '/' . $url->url)) {
            logEvent("FILE DELETED", "file: $url->url deleted", "index.php?page=profile");
        } else {
            logEvent("CRITICAL ERROR", "Error when deleting file", "index.php?page=profile", LOG_LVL_CRITICAL);
        }
    }

    logEvent("DELETE", "User [" . $_SESSION['user'] . "] deleted url [$deleteId]", "index.php?page=profile");
    $bdd->deleteUrlByID($deleteId);

    unset($_GET['delete']);
    header('Location: index.php?page=profile');
    exit();
}

// Update
$updateId = filter_input(INPUT_GET, 'updateId', FILTER_VALIDATE_INT);
$is_active = filter_input(INPUT_GET, 'updateActive', FILTER_VALIDATE_BOOLEAN);
if ($updateId && isset($_GET['updateActive'])) {

    if (!$bdd->validateUrlOwner($updateId, $_SESSION['user'])) {
        logEvent("DENIED", "User [" . $_SESSION['user'] . "] tried to update url [$updateId] but is not the owner", "index.php?page=profile", LOG_LVL_CRITICAL);
        header("Location: index.php?page=profile");
        die();
    }

    logEvent("UPDATE", ($is_active ? "disabled" : "enabled") . " url [$updateId]", "index.php?page=profile");
    $bdd->setActive($updateId, $is_active ? 0 : 1);
    unset($_GET['updateId']);
    unset($_GET['updateActive']);
    header('Location: index.php?page=profile');
    exit();
}
