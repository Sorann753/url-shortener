<!DOCTYPE html>
<html lang="en" class="h-100 w-100">

<?php require_once ROOT_PATH . '/views/includes/head.php' ?>

<body class="d-flex h-100 text-center text-bg-dark">
    <h1><span class="badge badge-danger">Welp, everything is dead, please come back later</span></h1>

    <p class="alert alert-primary" role="alert">
        <?= $error ?>
    </p>
    <!-- FOOTER -->
    <?php require_once ROOT_PATH . '/views/includes/footer.php'; ?>
</body>

</html>