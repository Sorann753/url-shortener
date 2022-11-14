<!DOCTYPE html>
<html lang="en" class="h-100 w-100">

<?php require_once ROOT_PATH . '/views/includes/head.php' ?>

<body class="d-flex h-100 text-center text-bg-dark">
    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
        <!-- HEADER -->
        <?php require ROOT_PATH . '/views/includes/header.php'; ?>

        <!-- CONTENT -->
        <main class="px-4 pb-4 pt-2 border rounded">
            <h1>Sign Up</h1>
            <p class="lead">Please enter your credentials to create your account.</p>
            <form action="" method="POST" class="mx-auto px-4 row row-cols-3 g-4">
                <input type="email" class="form-control form-control-dark text-bg-dark text-center fs-4" placeholder="Email" aria-label="Email" name="email" id="email">
                <input type="text" class="form-control form-control-dark text-bg-dark text-center fs-4" placeholder="Username" aria-label="Username" name="username" id="username">
                <input type="password" class="form-control form-control-dark text-bg-dark text-center fs-4" placeholder="Password" aria-label="Password" name="password" id="password">
                <input type="submit" class="btn btn-lg btn-secondary text-black fw-bold border-white bg-white w-100" value="Sign Up">
            </form>
        </main>

        <!-- FOOTER -->
        <?php require_once ROOT_PATH . '/views/includes/footer.php'; ?>
    </div>
</body>

</html>