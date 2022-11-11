<footer class="mt-auto">
    <ul class="nav justify-content-center border-bottom pb-3 mb-3">
        <li class="nav-item"><a href="index.php?page=home" class="nav-link px-2 text-muted">Home</a></li>
        <?php if (userConnected()) : ?>
            <li class="nav-item"><a href="index.php?page=profile" class="nav-link px-2 text-muted">Profile</a></li>
        <?php endif; ?>
    </ul>
    <p class="text-center text-muted">© 2022 Company, Inc</p>
</footer>