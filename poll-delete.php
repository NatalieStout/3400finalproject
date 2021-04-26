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
    $stmt = $pdo->prepare('SELECT * FROM polls WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $poll = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$poll) {
        message('Error: Poll does not exist with that ID.', 'polls.php', true);
    }

    if (isset($_GET['confirm'])) {
        if($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM polls WHERE id = ?');
            $stmt->execute([$_GET['id']]);
            // We also need to delete the answers for that poll
            $stmt = $pdo->prepare('DELETE FROM poll_answers WHERE poll_id = ?');
            $stmt->execute([$_GET['id']]);
            // Output msg
            message('Poll deleted successfully.', 'polls.php', false);
        } else {
            // User clicked the "No" button, redirect them back to the home/index page
            header('Location: polls.php');
            exit;
        }
    }
} else {
    message('Error: No ID specified.', 'polls.php', true);
}
//additional php code for this page goes here

?>

<?= template_header('Delete Poll') ?>
<?= template_nav(isset($_SESSION['loggedin'])) ?>
<div class = "columns">
    <!-- START LEFT NAV COLUMN-->
    <?= template_menu(isset($_SESSION['loggedin'])) ?>
    <!-- START PAGE CONTENT -->
    <div class = "column" >
        <h1 class="title">Delete Poll</h1>

        <h2 class="subtitle">Are you sure you want to delete poll number: <?=$poll['id']?></h2>
        <a href="poll-delete.php?id=<?=$poll['id']?>&confirm=yes" class="button is-success">Yes</a>
        <a href="poll-delete.php?id=<?=$poll['id']?>&confirm=no" class="button is-danger">No</a>
    </div>
</div>
    <!-- END PAGE CONTENT -->

<?= template_footer() ?>