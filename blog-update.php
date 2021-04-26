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
    // Get the post from the database
    $stmt = $pdo->prepare("SELECT * FROM blog_post WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $post = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$post) {
        // exit("post doesn't exist with that ID!");
        message("Post doesn't exist with that ID!", 'admin.php', true);
    }

    if(!empty($_POST)) {
        $author_name = isset($_POST['author_name']) ? $_POST['author_name'] : '';
        $title = isset($_POST['title']) ? $_POST['title'] : '';
        $content = isset($_POST['content']) ? $_POST['content'] : '';
        $published = isset($_POST['published']) ? $_POST['published'] : '';
        $created = isset($_POST['created']) ? $_POST['created'] : date('Y-m-d H:i:s');

        $stmt = $pdo->prepare('UPDATE blog_post SET id = ?, author_name = ?, title = ?, content = ?, published = ?, created = ? WHERE id = ?');
        $stmt->execute([$_GET['id'], $author_name, $title, $content, $published, $created, $_GET['id']]);
        message('post updated successfully.', 'blog-admin.php', false);
    }
} else {
    // exit('No ID specified');
    message('Error: No ID specified.', 'admin.php', true);
}

?>

<?= template_header('Post Update') ?>
<?= template_nav(isset($_SESSION['loggedin'])) ?>

<!-- START PAGE CONTENT -->
<div class = "columns">
    <!-- START LEFT NAV COLUMN-->
    <?= template_menu(isset($_SESSION['loggedin'])) ?>
    <div class = "column" >
        <h1 class="title">Post Update</h1>

        <form action="blog-update.php?id=<?=$post['id']?>" method="POST">
            <div class="field">
                <label class="label">Author</label>
                <div class="control">
                    <input type="text" name="author_name" class="input" value="<?=$post['author_name']?>" required>
                </div>
            </div>
            <div class="field">
                <label class="label">Title</label>
                <div class="control">
                    <input type="text" name="title" class="input" value="<?=$post['title']?>" required>
                </div>
            </div>
            <div class="field">
                <label class="label">Content</label>
                <div class="control">
                    <input type="text" name="content" class="input" value="<?=$post['content']?>" required>
                </div>
            </div>
            <div class="field">
                <label class="label">Published</label>
                <div class="control">
                    <input type="text" name="published" class="input" value="<?=$post['published']?>" required>
                </div>
            </div>
            <div class="field">
                <div class="control">
                    <input type="submit" class="button" value="Update">
                </div>
            </div>
        </form>
    </div>
</div>
    <!-- END PAGE CONTENT -->

<?= template_footer() ?>