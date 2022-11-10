<?php
require_once './config/const.php';
require ROOT_PATH . '/config/database.conf.php';
?>

<!DOCTYPE html>
<html lang="en" class="h-100 w-100">

<?php require_once ROOT_PATH . '/includes/header.php' ?>

<body class="d-flex h-100 text-center text-bg-dark spa">
    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
        <!-- HEADER -->
        <header class="mb-auto">
            <div class="container">
                <nav class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                    <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                        <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap">
                            <img src="./favicon_io/favicon-32x32.png" alt="Logo" />
                        </svg>
                    </a>

                    <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                        <li><a href="#" class="nav-link px-2 text-secondary">Home</a></li>
                        <li><a href="#" class="nav-link px-2 text-white">Features</a></li>
                        <li><a href="#" class="nav-link px-2 text-white">Pricing</a></li>
                        <li><a href="#" class="nav-link px-2 text-white">FAQs</a></li>
                        <li><a href="#" class="nav-link px-2 text-white">About</a></li>
                    </ul>

                    <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
                        <input type="search" class="form-control form-control-dark text-bg-dark" placeholder="Search..." aria-label="Search">
                    </form>

                    <div class="text-end">
                        <button type="button" class="btn btn-outline-light me-2">Login</button>
                        <button type="button" class="btn btn-warning">Sign-up</button>
                    </div>
                </nav>
            </div>
        </header>

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
        <footer class="mt-auto">
            <ul class="nav justify-content-center border-bottom pb-3 mb-3">
                <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Home</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Features</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Pricing</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">FAQs</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">About</a></li>
            </ul>
            <p class="text-center text-muted">© 2022 Company, Inc</p>
        </footer>
    </div>
</body>

</html>