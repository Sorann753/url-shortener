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
            <form method="POST" class="mx-auto px-4 mt-5 d-flex form-group">
                <input type="text" class="form-control form-control-dark text-bg-dark text-center" placeholder="https://www.youtube.com/watch?v=dQw4w9WgXcQ" aria-label="https://www.youtube.com/watch?v=dQw4w9WgXcQ" name="url" id="url">
                <input type="submit" name="submit" class="btn btn-md btn-secondary text-black fw-bold border-white bg-white ms-3 w-50 fs-5" value="Short URL">
            </form>

            <!-- UPLOAD FORM -->
            <div class="my-3">
                <form enctype="multipart/form-data" class="mx-auto px-4" method="post">
                    <div class="mb-3 d-flex">
                        <input class="form-control form-control-lg text-bg-dark" type="file" id="file" name="file">
                        <input type="submit" class="btn btn-md btn-secondary text-black fw-bold border-white bg-white ms-3 w-50 fs-5" value="Upload" />
                    </div>
                </form>
            </div>

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