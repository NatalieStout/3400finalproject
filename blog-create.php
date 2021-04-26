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

// Check if the POST data is not empty
if (!empty($_POST)) {
    // Check to see if the data from the form is set
    $author_name = isset($_POST['author_name']) ? $_POST['author_name'] : '';
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $content = isset($_POST['content']) ? $_POST['content'] : '';
    $published = isset($_POST['published']) ? $_POST['published'] : '';
    $created = isset($_POST['created']) ? $_POST['created'] : date('Y-m-d H:i:s');
    
    // Insert the new post record into the blog table
    $stmt = $pdo->prepare('INSERT INTO blog_post VALUES (NULL, ?, ?, ?, ?, ?)');
    $stmt->execute([$author_name, $title, $content, $published, $created]);

    // $msg = "post created successfully!";
    message('Post created successfully!', 'blog-admin.php', false);
}

?>

<?= template_header('Create Blog Post') ?>
<?= template_nav(isset($_SESSION['loggedin'])) ?>

<div class = "columns">
    <!-- START LEFT NAV COLUMN-->
    <?= template_menu(isset($_SESSION['loggedin'])) ?>
    <!-- START PAGE CONTENT -->
    <div class = "column" >
        <!-- START PAGE CONTENT -->
        <h1 class="title">Create Blog Post</h1>

        <form action="" method="POST">
            <div class="field">
                <label class="label">Author Name</label>
                <div class="control">
                    <input class="input" type="text" name="author_name" placeholder="Author Name" required>
                </div>
            </div>
            <div class="field">
                <label class="label">Title</label>
                <div class="control">
                    <input class="input" type="text" name="title" placeholder="Title">
                </div>
            </div>
            <div class="field">
                <label class="label">Content</label>
                <div class="control">
                    <input class="input" type="text" name="content" placeholder="Content">
                </div>
            </div>
            <div class="field">
                <label class="label">Published</label>
                <div class="control">
                    <input class="input" type="text" name="published" placeholder="Type '1' to publish">
                </div>
            </div>
            <div class="field">
                <div class="control">
                    <button class="button is-link">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
    <!-- END PAGE CONTENT -->

<?= template_footer() ?>