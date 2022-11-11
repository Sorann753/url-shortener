<?php
$urls = $bdd->getUserUrls(1);
?>
<!DOCTYPE html>
<html lang="en" class="h-100 w-100">

<?php require_once ROOT_PATH . '/views/includes/head.php' ?>

<body class="d-flex h-100 text-center text-bg-dark">
    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
        <!-- HEADER -->
        <?php require ROOT_PATH . '/views/includes/header.php'; ?>

        <!-- CONTENT -->
        <main class="px-3">
            <table class="rounded table table-dark">
                <thead>
                    <tr>
                        <th class="col">#</th>
                        <th class="col">Original</th>
                        <th class="col">Shortened</th>
                        <th class="col">Times clicked</th>
                        <th colspan="2" class="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($urls as $url) : ?>
                        <tr>
                            <th scope="row"><?= $url->id ?></th>
                            <td><?= $url->url ?></td>
                            <td><?= 'http://' . shortenUrl($url->short_url)[0]; ?></td>
                            <td><?= $url->nb_click ?></td>
                            <td>
                                <a href="delete.php?id=<?= $url->id ?>" class="btn btn-outline-danger">
                                    Delete
                                </a>
                            </td>
                            <td>
                                <a href="publish.php?id=<?= $url->is_active ?>" class="btn btn-outline-warning">
                                    <?php if ($url->is_active) : ?>
                                        Unpublish
                                    <?php else : ?>
                                        Publish
                                    <?php endif; ?>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </main>

        <!-- FOOTER -->
        <?php require_once ROOT_PATH . '/views/includes/footer.php'; ?>
    </div>
</body>

</html>