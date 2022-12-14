<header class="mb-auto">
    <nav class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="index.php?page=home" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
            <img src="./assets/favicon_io/favicon-32x32.png" alt="Logo" />
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
            <li><a href="index.php?page=home" class="nav-link px-2 text-secondary">Home</a></li>
            <?php if (userConnected()) : ?>
                <li><a href="index.php?page=profile" class="nav-link px-2 text-white">Profile</a></li>
            <?php endif; ?>
        </ul>

        <div class="text-end d-flex flex-wrap align-items-center justify-content-center justify-content-lg-end">
            <?php if (userConnected()) : ?>
                <p class="lead me-4 pt-2">Welcome <strong><?= $bdd->getUsernameByEmail($_SESSION['user']) ?></strong></p>
                <a href="index.php?page=logout" class="btn btn-danger me-2">Logout</a>
            <?php else : ?>
                <a href="index.php?page=login" class="btn btn-outline-light me-2">Login</a>
                <a href="index.php?page=signUp" class="btn btn-warning">Sign-up</a>
            <?php endif; ?>
            <?php if ($page === 'profile') : ?>
                <!-- Button trigger modal -->
                <button href="index.php?page=profile" class="px-2 text-white btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#userDelete">Delete Account</button>
            <?php endif; ?>
        </div>
    </nav>
    <?php if (isset($error)) { ?>

        <h2>
            <popup class="badge text-bg-danger" role="alert">
                <?php echo $error; ?>
            </popup>
        </h2>

    <?php } ?>
</header>