<?php
require_once './config/const.php';
require ROOT_PATH . '/config/database.conf.php';
?>

<!DOCTYPE html>
<html lang="en" class="h-100 w-100">

<?php require_once ROOT_PATH . '/includes/head.php' ?>

<body class="d-flex h-100 text-center text-bg-dark spa">
    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
        <!-- HEADER -->
        <?php require ROOT_PATH . '/includes/header.php'; ?>

        <!-- CONTENT -->
        <main class="px-3">
            <h1>Welcome to Url Shortener !</h1>
            <p class="lead">It's very simple ! You want a preview ? No problem ! Try it below !</p>
            <form class="mx-auto d-flex px-4">
                <input type="text" class="form-control form-control-dark text-bg-dark text-center" placeholder="https://www.youtube.com/watch?v=dQw4w9WgXcQ" aria-label="https://www.youtube.com/watch?v=dQw4w9WgXcQ" name="url" id="url">
                <input type="submit" class="btn btn-lg btn-secondary text-black fw-bold border-white bg-white ms-3" value="Short URL">
            </form>
        </main>

        <!-- FOOTER -->
        <?php require_once ROOT_PATH . '/includes/footer.php'; ?>
    </div>
</body>

</html>