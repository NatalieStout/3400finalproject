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
        $stmt = $pdo->prepare('SELECT * from poll_answers WHERE poll_id = ?');
        $stmt->execute([$_GET['id']]);

        // Fetch the records
        $poll_answers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // If the user clicked the "Vote" button...
        if (isset($_POST['poll_answer'])) {
            // Update the vote answer by 1
            $stmt = $pdo->prepare('UPDATE poll_answers SET votes = votes + 1 WHERE id = ? ');
            $stmt->execute([$_POST['poll_answer']]);
            header('Location: poll-result.php?id=' . $_GET['id']);
            exit;
        }
    } else {
        message('Error: Poll does not exist with that ID.', 'polls.php', true);
    }
} else {
    message('Error: No ID specified.', 'polls.php', true);
}

?>

<?= template_header('Poll Vote') ?>
<?= template_nav(isset($_SESSION['loggedin'])) ?>
<div class = "columns">
    <!-- START LEFT NAV COLUMN-->
    <?= template_menu(isset($_SESSION['loggedin'])) ?>
    <!-- START PAGE CONTENT -->
    <div class = "column" >
        <h1 class="title">Poll Vote - <?= $poll['title'] ?></h1>
        <h2 class="subtitle"><?= $poll['desc'] ?></h2>
        <form action="poll-vote.php?id=<?= $_GET['id'] ?>" method="POST">
            <?php for ($i = 0; $i < count($poll_answers); $i++) : ?>
                <div class="control">
                    <label class="radio">
                        <input type="radio" name="poll_answer" value="<?=$poll_answers[$i]['id']?>" <?= $i == 0 ? ' checked' : ''?>>
                        <?=$poll_answers[$i]['title']?>
                    </label>
                </div>
            <?php endfor; ?>
            <div class="field">
                <div class="control">
                    <button class="button is-success" value="Vote" type="submit">Vote</button>
                </div>
            </div>
        </form>
    </div>
</div>
    <!-- END PAGE CONTENT -->

<?= template_footer() ?>