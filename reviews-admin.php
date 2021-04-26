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
$stmt = $pdo->query('SELECT * FROM reviews');
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

        <h1 class="title">Reviews</h1>
        <p>Welcome, view the list of reviews below.</p>
        <div class="container">
            <table class="table is-bordered is-hoverable">
                <thead>
                    <td>#</td>
                    <td>Page ID</td>
                    <td>Name</td>
                    <td>Content</td>
                    <td>Rating</td>
                </thead>
                <tbody>
                    <?php foreach ($reviews as $review): ?>
                        <tr>
                            <td>
                                <?= $review['id'] ?>
                            </td>
                            <td>
                                <?= $review['page_id'] ?>
                            </td>
                            <td>
                                <?= $review['name'] ?>
                            </td>
                            <td>
                                <?= $review['content'] ?>
                            </td>
                            <td>
                                <?= $review['rating'] ?>
                            </td>
                            <td>
                                <a href="reviews-update.php?id=<?=$review['id']?>" class="button is-link is-small" title="Edit Review">
                                    <span class="icon"><i class="fas fa-user-edit"></i></span>
                                </a>
                                <a href="reviews-delete.php?id=<?=$review['id']?>" class="button is-link is-small is-danger" title="Delete Review">
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