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
    // Get the review from the database
    $stmt = $pdo->prepare("SELECT * FROM reviews WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $review = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$review) {
        // exit("review doesn't exist with that ID!");
        message("Review doesn't exist with that ID!", 'reviews-admin.php', true);
    }

    if(!empty($_POST)) {
        $page_id = isset($_POST['page_id']) ? $_POST['page_id'] : '';
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $content = isset($_POST['content']) ? $_POST['content'] : '';
        $rating = isset($_POST['rating']) ? $_POST['rating'] : '';
        $created = isset($_POST['created']) ? $_POST['created'] : date('Y-m-d H:i:s');

        $stmt = $pdo->prepare('UPDATE reviews SET id = ?, page_id = ?, name = ?, content = ?, rating = ?, created = ? WHERE id = ?');
        $stmt->execute([$_GET['id'], $page_id, $name, $content, $rating, $created, $_GET['id']]);
        message('Review updated successfully.', 'reviews-admin.php', false);
    }
} else {
    // exit('No ID specified');
    message('Error: No ID specified.', 'reviews.php', true);
}

?>

<?= template_header('Reviews Update') ?>
<?= template_nav(isset($_SESSION['loggedin'])) ?>

<!-- START PAGE CONTENT -->
<div class = "columns">
    <!-- START LEFT NAV COLUMN-->
    <?= template_menu(isset($_SESSION['loggedin'])) ?>
    <div class = "column" >
        <h1 class="title">Review Update</h1>

        <form action="reviews-update.php?id=<?=$review['id']?>" method="POST">
            <div class="field">
                <label class="label">page_id</label>
                <div class="control">
                    <input type="text" name="page_id" class="input" value="<?=$review['page_id']?>" required>
                </div>
            </div>
            <div class="field">
                <label class="label">name</label>
                <div class="control">
                    <input type="text" name="name" class="input" value="<?=$review['name']?>" required>
                </div>
            </div>
            <div class="field">
                <label class="label">content</label>
                <div class="control">
                    <input type="text" name="content" class="input" value="<?=$review['content']?>" required>
                </div>
            </div>
            <div class="field">
                <label class="label">rating</label>
                <div class="control">
                    <input type="text" name="rating" class="input" value="<?=$review['rating']?>" required>
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