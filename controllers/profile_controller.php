<?php

/**
 * handle the removal of an url or a file from the website
 * @param int $deleteId
 * @param Bdd $bdd
 * @return bool TRUE on success or FALSE on failure.
 */
function remove($deleteId, $bdd)
{
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
                return false;
            }
        }

        logEvent("DELETE", "User [" . $_SESSION['user'] . "] deleted url [$deleteId]", "index.php?page=profile");
        $bdd->deleteUrlByID($deleteId);

        unset($_GET['delete']);
        return true;
    }
    return false;
}

/**
 * handle the activation or deactivation of an url
 * @param int $updateId
 * @param $isActivate
 * @param Bdd $bdd
 * @return void
 */
function update($updateId, $is_active, $bdd)
{
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
}

/**
 * handle the removal of a user from the website
 * @param string $deleteAccount
 * @param Bdd $bdd
 * @return void
 */
function removeUser($deleteAccount, $bdd)
{
    if (isset($deleteAccount) && userConnected()) {
        $urls = $bdd->getUserUrls($_SESSION['user']);
        foreach ($urls as $url) {
            if ($url->is_file) {
                remove($url->id, $bdd);
            }
        }

        $isDeleted = $bdd->deleteUserByEmail($_SESSION['user']);
        unset($_SESSION['user']);
        if ($isDeleted) {
            logEvent("USER DELETED", "User [" . $_SESSION['user'] . "] has deleted his account", "index.php?page=profile");
        } else {
            logEvent("CRITICAL ERROR", "Error when deleting user", "index.php?page=profile", LOG_LVL_CRITICAL);
        }
        header("Location: index.php?page=home");
        die();
    }
}





if (userConnected()) {
    $urls = $bdd->getUserUrls($_SESSION['user']);
} else {
    logEvent("DENIED", "unconected user trying to access profile page", "index.php?page=profile", LOG_LVL_VERBOSE);
    header("Location: index.php?page=login");
    die();
}

// Delete User
$deleteAccount = filter_input(INPUT_POST, 'deleteAccount');
removeUser($deleteAccount, $bdd);


// Delete
$deleteId = filter_input(INPUT_GET, 'delete', FILTER_VALIDATE_INT);
if (remove($deleteId, $bdd)) {
    header('Location: index.php?page=profile');
    die();
}

// Update
$updateId = filter_input(INPUT_GET, 'updateId', FILTER_VALIDATE_INT);
$is_active = filter_input(INPUT_GET, 'updateActive', FILTER_VALIDATE_BOOLEAN);
update($updateId, $is_active, $bdd);
