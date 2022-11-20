<!DOCTYPE html>
<html lang="en" class="h-100 w-100">

<?php require_once ROOT_PATH . '/views/includes/head.php' ?>

<body class="d-flex h-100 text-center text-bg-dark">
    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
        <!-- HEADER -->
        <?php require ROOT_PATH . '/views/includes/header.php'; ?>

        <!-- CONTENT -->
        <main class="px-3">
            <!-- Modal -->
            <form class="modal fade" id="userDelete" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true" method="POST">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 text-black" id="modalTitle">Deleting your Account</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-danger">
                            Are you sure to delete your account ?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
                            <button type="submit" class="btn btn-success" name="deleteAccount">Yes</button>
                        </div>
                    </div>
                </div>
            </form>

            <!-- TABLE -->
            <div class="rounded border p-3">
                <table class="table table-dark table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="col">Original</th>
                            <th class="col">Shortened</th>
                            <th class="col">Times clicked</th>
                            <th class="col">QR Code</th>
                            <th colspan="2" class="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($urls as $url) : ?>
                            <tr class="align-middle">
                                <td><a href="<?= $url->url; ?>" class="text-decoration-none text-success" target="_blank"><?= $url->url; ?></a></td>
                                <td><a href="<?= BASE_URL . '?url=' . $url->short_url; ?>" class="text-decoration-none text-info" target="_blank"><?= BASE_URL . '?url=' . $url->short_url; ?></a></td>
                                <td><?= $url->nb_click; ?></td>
                                <td>
                                    <a href="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=<?= urlencode(BASE_URL . '?url=' . $url->short_url); ?>" target="_blank">
                                        <img width="52" height="52" src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=<?= urlencode(BASE_URL . '?url=' . $url->short_url); ?>" alt="QR Code" class="mx-auto rounded border p-1">
                                    </a>
                                </td>
                                <td>
                                    <a href="index.php?page=profile&delete=<?= $url->id; ?>" class="btn btn-outline-danger">
                                        Delete
                                    </a>
                                </td>
                                <td>
                                    <a href="index.php?page=profile&updateId=<?= $url->id; ?>&updateActive=<?= $url->is_active; ?>" class="btn btn-outline-warning">
                                        <?php if ($url->is_active) : ?>
                                            Disable
                                        <?php else : ?>
                                            Enable
                                        <?php endif; ?>
                                    </a>
                                </td>

                                <!-- TODO: add a button to show the QR code -->
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>

        <!-- FOOTER -->
        <?php require_once ROOT_PATH . '/views/includes/footer.php'; ?>
    </div>
</body>

</html>