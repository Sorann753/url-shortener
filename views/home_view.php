<!DOCTYPE html>
<html lang="en" class="h-100 w-100">

<?php require_once ROOT_PATH . '/views/includes/head.php' ?>

<body class="d-flex h-100 text-center text-bg-dark">
    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
        <!-- HEADER -->
        <?php require ROOT_PATH . '/views/includes/header.php'; ?>

        <!-- CONTENT -->
        <main class="px-3">
            <h1>Welcome <?= (userConnected()) ? $bdd->getUsernameByEmail($_SESSION['user']) : "" ?> to Url Shortener !
            </h1>
            <p class="lead">It's very simple ! You want a previews ? No problem ! Try it below !</p>

            <!-- URL SHORTENER FORM -->
            <form action="" method="POST" class="mx-auto d-flex px-4 form-group">
                <input type="text" class="form-control form-control-dark text-bg-dark text-center fs-4" placeholder="https://www.youtube.com/watch?v=dQw4w9WgXcQ" aria-label="https://www.youtube.com/watch?v=dQw4w9WgXcQ" name="url" id="url">
                <input type="submit" class="btn btn-lg btn-secondary text-black fw-bold border-white bg-white ms-3" value="Short URL">
            </form>

            <!-- UPLOAD FORM -->
            <form enctype="multipart/form-data" class=" mx-auto px-4 mt-4" method="post">
                <label for="file">Please select your file :</label>
                <input type="file" class="form-control-file" id="file" name="file" />
                <input type="submit" class="btn btn-lg btn-secondary text-black fw-bold border-white bg-white ms-3" value="Upload" />
            </form>

            <?php if (isset($newShortUrl)) : ?>
                <section class="alert alert-success mt-4 border rounded d-flex flex-column px-4 justify-content-center" role="alert">
                    <h4 class="alert-heading">Your short url is ready !</h4>
                    <p>Copy this url and share it with your friends !</p>
                    <a href="<?= $newShortUrl ?>" class="mb-0 text-center text-info mx-5 justify-content-center">
                        <?= $newShortUrl ?>
                    </a>
                    <p>Or use this QR code</p>
                    <img width="150" height="150" src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=<?= urlencode($newShortUrl) ?>" alt="QR Code" class="mx-auto">
                </section>
            <?php endif; ?>
        </main>

        <!-- FOOTER -->
        <?php require_once ROOT_PATH . '/views/includes/footer.php'; ?>
    </div>
</body>

</html>