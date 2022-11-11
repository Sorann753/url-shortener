<!DOCTYPE html>
<html lang="en" class="h-100 w-100">

<?php require_once ROOT_PATH . '/views/includes/head.php' ?>

<body class="d-flex h-100 text-center text-bg-dark">
    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
        <!-- HEADER -->
        <?php require ROOT_PATH . '/views/includes/header.php'; ?>

        <!-- CONTENT -->
        <main class="px-3">
            <div class="rounded border p-3">
                <table class="table table-dark">
                    <thead>
                        <tr>
                            <th class="col">Original</th>
                            <th class="col">Shortened</th>
                            <th class="col">Times clicked</th>
                            <th colspan="2" class="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($urls as $url) : ?>
                            <tr>
                                <td><?= $url->url; ?></td>
                                <td><?= 'http://localhost/index?url=' . $url->short_url; ?></td>
                                <td><?= $url->nb_click; ?></td>
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