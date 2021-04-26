<?php
require 'config.php';

session_start();

// Connect to MySQL
$pdo = pdo_connect_mysql();

// If the GET request "id" exists (poll id)...
if (isset($_GET['id'])) {
    // MySQL query that selects the poll records by the GET request "id"
    $stmt = $pdo->prepare('SELECT * FROM polls WHERE id = ?');
    $stmt->execute([$_GET['id']]);

    // Fetch the record
    $poll = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Check if the poll record exists with the id specified
    if ($poll) {
        // MySQL query that selects all the poll answers
        $stmt = $pdo->prepare('SELECT * from poll_answers WHERE poll_id = ? ORDER BY votes DESC');
        $stmt->execute([$_GET['id']]);

        // Fetch the records
        $poll_answers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $total_votes = 0;

        foreach ($poll_answers as $poll_answer) {
            $total_votes += $poll_answer['votes'];
        }

    } else {
        message('Error: Poll does not exist with that ID.', 'polls.php', true);
    }
} else {
    message('Error: No ID specified.', 'polls.php', true);
}

?>

<?= template_header('Poll Results') ?>
<?= template_nav(isset($_SESSION['loggedin'])) ?>
<div class = "columns">
    <!-- START LEFT NAV COLUMN-->
    <?= template_menu(isset($_SESSION['loggedin'])) ?>
    <!-- START PAGE CONTENT -->
    <div class = "column" >
        <h1 class="title">Poll Results</h1>
        <h2 class="subtitle"><?= $poll['title'] ?> (Total Votes: <?= $total_votes ?>)</h2>
        <div class="container">
            <?php foreach ($poll_answers as $poll_answer) : ?>
                <p><?= $poll_answer['title'] ?> (<?= $poll_answer['votes'] ?> votes)</p>
                <progress class="progress is-info is-large" 
                        value="<?= $poll_answer['votes']?>" 
                        max="<?= $poll_answers[0]['votes']?>"></progress>
            <?php endforeach; ?>
        </div>
    </div>
</div>
    <!-- END PAGE CONTENT -->

<?= template_footer() ?>