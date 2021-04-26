<?php
require 'config.php';

session_start();

$msg = "";
$err = false;

if (isset($_GET['msg'], $_GET['err'])) {
    $msg = $_GET['msg'];
    $err = $_GET['err'];
}

// Connect to MySQL
$pdo = pdo_connect_mysql();

// Query that selects all the polls from the database
$stmt = $pdo->query('SELECT p.*, GROUP_CONCAT(pa.title ORDER BY pa.id) AS answers
                     FROM polls p LEFT JOIN poll_answers pa ON pa.poll_id = p.id
                     GROUP BY p.id');
$polls = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        <h1 class="title">Polls</h1>
        <p>Welcome, view our list of polls below.</p>
        <a href="poll-create.php" class="button is-primary is-small my-4">
            <span class="icon"><i class="fas fa-plus-square"></i></span>
            <span>Create Poll</span>
        </a>
        <div class="container">
            <table class="table is-bordered is-hoverable">
                <thead>
                    <td>#</td>
                    <td>Title</td>
                    <td>Answers</td>
                    <td>Action</td>
                </thead>
                <tbody>
                    <?php foreach ($polls as $poll): ?>
                        <tr>
                            <td>
                                <?= $poll['id'] ?>
                            </td>
                            <td>
                                <?= $poll['title'] ?>
                            </td>
                            <td>
                                <?= $poll['answers'] ?>
                            </td>
                            <td>
                                <a href="poll-vote.php?id=<?=$poll['id']?>" class="button is-link is-small" title="View Poll">
                                    <span class="icon"><i class="fas fa-eye"></i></span>
                                </a>
                                <a href="poll-delete.php?id=<?=$poll['id']?>" class="button is-link is-small is-danger" title="Delete Poll">
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