<?php
$urls = $bdd->getUserUrls(1);

// Delete
if (isset($_GET['delete'])) {
    var_dump("Delete");
    $id = filter_input(INPUT_GET, 'delete');
    $bdd->deleteUrlByID($id);
    unset($_GET['delete']);
    header('Location: /index.php?page=profile');
}
