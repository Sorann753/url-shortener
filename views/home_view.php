<!DOCTYPE html>
<html lang="en" class="h-100 w-100">

    <?php require_once ROOT_PATH . '/views/includes/head.php' ?>

    <body class="d-flex h-100 text-center text-bg-dark">
        <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
            <!-- HEADER -->
            <?php require ROOT_PATH . '/views/includes/header.php'; ?>

            <!-- CONTENT -->
            <main class="px-3">
                <h1>Welcome to Url Shortener !</h1>
                <p class="lead">It's very simple ! You want a previews ? No problem ! Try it below !</p>
                <form action="" method="POST" class="mx-auto d-flex px-4">
                    <input type="text" class="form-control form-control-dark text-bg-dark text-center fs-4" placeholder="https://www.youtube.com/watch?v=dQw4w9WgXcQ" aria-label="https://www.youtube.com/watch?v=dQw4w9WgXcQ" name="url" id="url">
                    <input type="submit" class="btn btn-lg btn-secondary text-black fw-bold border-white bg-white ms-3" value="Short URL">
                </form>

                <?php if (isset($newShortUrl)) : ?>
                    <section class="alert alert-success mt-3" role="alert">
                        <h4 class="alert-heading">Your short url is ready !</h4>
                        <p>Copy this url and share it with your friends !</p>
                        <hr>
                        <p class="mb-0"><?= $newShortUrl ?></p>
                    </section>
                <?php endif; ?>
            </main>

            <!-- FOOTER -->
            <?php require_once ROOT_PATH . '/views/includes/footer.php'; ?>
        </div>
    </body>
</html>