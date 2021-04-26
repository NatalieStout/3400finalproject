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
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $desc = isset($_POST['desc']) ? $_POST['desc'] : '';
    
    // Insert the new poll record into the polls table
    $stmt = $pdo->prepare('INSERT INTO polls VALUES (NULL, ?, ?)');
    $stmt->execute([$title, $desc]);

    $poll_id = $pdo->lastInsertId();

    // Get the answers and convert the multiline string to an array, so we can insert each answer
    $answers = isset($_POST['answers']) ? explode(PHP_EOL, $_POST['answers']) : '';

    foreach($answers as $answer) {
        if (empty($answers)) continue ;
        // Add answer to the answers table
        $stmt = $pdo->prepare('INSERT INTO poll_answers VALUES (NULL, ?, ?, 0)');
        $stmt->execute([$poll_id, $answer]);
    }
    message("Poll created successfully!", 'polls.php', false);
}

?>

<?= template_header('Create Poll') ?>
<?= template_nav(isset($_SESSION['loggedin'])) ?>
<div class = "columns">
    <!-- START LEFT NAV COLUMN-->
    <?= template_menu(isset($_SESSION['loggedin'])) ?>
    <!-- START PAGE CONTENT -->
    <div class = "column" >
        <h1 class="title">Create Poll</h1>

        <form action="" method="POST">
            <div class="field">
                <label class="label">Title</label>
                <div class="control">
                    <input class="input" type="text" name="title" placeholder="Poll Title">
                </div>
            </div>
            <div class="field">
                <label class="label">Description</label>
                <div class="control">
                    <input class="input" type="text" name="desc" placeholder="Poll Description">
                </div>
            </div>
            <div class="field">
                <label class="label">Answers (per line)</label>
                <div class="control">
                    <textarea class="textarea" name="answers" placeholder="Answers"></textarea>
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