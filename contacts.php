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
$stmt = $pdo->query('SELECT * FROM contacts');
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

        <h1 class="title">Contacts</h1>
        <p>Welcome, view our list of contacts below.</p>
        <a href="contact-create.php" class="button is-primary is-small my-4">
            <span class="icon"><i class="fas fa-plus-square"></i></span>
            <span>Create Contact</span>
        </a>
        <div class="container">
            <table class="table is-bordered is-hoverable">
                <thead>
                    <td>#</td>
                    <td>Name</td>
                    <td>Email</td>
                    <td>Phone</td>
                    <td>Title</td>
                    <td>Action</td>
                </thead>
                <tbody>
                    <?php foreach ($contacts as $contact): ?>
                        <tr>
                            <td>
                                <?= $contact['id'] ?>
                            </td>
                            <td>
                                <?= $contact['name'] ?>
                            </td>
                            <td>
                                <?= $contact['email'] ?>
                            </td>
                            <td>
                                <?= $contact['phone'] ?>
                            </td>
                            <td>
                                <?= $contact['title'] ?>
                            </td>
                            <td>
                                <a href="contact-update.php?id=<?=$contact['id']?>" class="button is-link is-small" title="Edit Contact">
                                    <span class="icon"><i class="fas fa-user-edit"></i></span>
                                </a>
                                <a href="contact-delete.php?id=<?=$contact['id']?>" class="button is-link is-small is-danger" title="Delete Contact">
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