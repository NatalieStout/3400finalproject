<?php
require 'config.php';

session_start();

if(!isset($_SESSION['loggedin'])){
    // header('Location: login.php');
    message("Please login first.", "login.php", true);
    exit;
}


// Connect to MySQL
$pdo = pdo_connect_mysql();

if (isset($_GET['id'])) {
    // Select the record that is going to be deleted.
    $stmt = $pdo->prepare('SELECT * FROM blog_post WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$post) {
        message('Error: Post does not exist with that ID.', 'admin.php', true);
    }

    if (isset($_GET['confirm'])) {
        if($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM blog_post WHERE id = ?');
            $stmt->execute([$_GET['id']]);
            // Output msg
            message('Post deleted successfully.', 'blog-admin.php', false);
        } else {
            // User clicked the "No" button, redirect them back to the home/index page
            header('Location: blog-admin.php');
            exit;
        }
    }
} else {
    message('Error: No ID specified.', 'admin.php', true);
}

?>

<?= template_header('Delete Post') ?>
<?= template_nav(isset($_SESSION['loggedin'])) ?>

<!-- START PAGE CONTENT -->
<div class = "columns">
    <!-- START LEFT NAV COLUMN-->
    <?= template_menu(isset($_SESSION['loggedin'])) ?>
    <!-- START PAGE CONTENT -->
    <div class = "column" >
        <h1 class="title">Delete Blog Post</h1>

        <h2 class="subtitle">Are you sure you want to delete blog post : <?=$post['title']?></h2>
        <a href="blog-delete.php?id=<?=$post['id']?>&confirm=yes" class="button is-success">Yes</a>
        <a href="blog-delete.php?id=<?=$post['id']?>&confirm=no" class="button is-danger">No</a>
    </div>
</div>
    <!-- END PAGE CONTENT -->

<?= template_footer() ?>