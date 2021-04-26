<?php
require 'config.php';

session_start();

// Connect to MySQL
$pdo = pdo_connect_mysql();

$msg = "";
$err = false;

if (isset($_GET['msg'], $_GET['err'])) {
    $msg = $_GET['msg'];
    $err = $_GET['err'];
}

// Query that selects all the polls from the database
$stmt = $pdo->query('SELECT * FROM blog_post');
$blog_post = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?= template_header('Polls') ?>
<?= template_nav(isset($_SESSION['loggedin'])) ?>
<div class = "columns">
    <!-- START LEFT NAV COLUMN-->
    <?= template_menu(isset($_SESSION['loggedin'])) ?>
    <!-- START PAGE CONTENT -->
    <div class = "column" >
        <?php if ($msg && !$err) : ?>
            <div class="notification is-success is-light py-2">
                <p><strong><?php echo $msg; ?></strong></p>
            </div>
        <?php elseif ($msg && $err) : ?>
            <div class="notification is-danger is-light py-2">
                <p><strong><?php echo $msg; ?></strong></p>
            </div>
        <?php endif; ?>

        <h1 class="title">Blog Posts</h1>
        <p>View your blog posts below.</p>
        <a href="blog-create.php" class="button is-primary is-small my-4">
            <span class="icon"><i class="fas fa-plus-square"></i></span>
            <span>Create Blog Post</span>
        </a>
        <div class="container">
            <table class="table is-bordered is-hoverable">
                <thead>
                    <td>#</td>
                    <td>Author</td>
                    <td>Title</td>
                    <td>Description</td>
                </thead>
                <tbody>
                    <?php foreach ($blog_post as $post): ?>
                        <tr>
                            <td>
                                <?= $post['id'] ?>
                            </td>
                            <td>
                                <?= $post['author_name'] ?>
                            </td>
                            <td>
                                <?= $post['title'] ?>
                            </td>
                            <td>
                                <?= $post['content'] ?>
                            </td>
                            <td>
                                <a href="blog-update.php?id=<?=$post['id']?>" class="button is-link is-small" title="Edit Blog Post">
                                    <span class="icon"><i class="fas fa-user-edit"></i></span>
                                </a>
                                <a href="blog-delete.php?id=<?=$post['id']?>" class="button is-link is-small is-danger" title="Delete Blog Post">
                                    <span class="icon"><i class="fas fa-trash-alt"></i></span>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
    <!-- END PAGE CONTENT -->

<?= template_footer() ?>