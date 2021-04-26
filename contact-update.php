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
    // Get the contact from the database
    $stmt = $pdo->prepare("SELECT * FROM contacts WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        // exit("Contact doesn't exist with that ID!");
        message("Contact doesn't exist with that ID!", 'contacts.php', true);
    }

    if(!empty($_POST)) {
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
        $title = isset($_POST['title']) ? $_POST['title'] : '';
        $created = isset($_POST['created']) ? $_POST['created'] : date('Y-m-d H:i:s');

        $stmt = $pdo->prepare('UPDATE contacts SET id = ?, name = ?, email = ?, phone = ?, title = ?, created = ? WHERE id = ?');
        $stmt->execute([$_GET['id'], $name, $email, $phone, $title, $created, $_GET['id']]);
        message('Contact updated successfully.', 'contacts.php', false);
    }
} else {
    // exit('No ID specified');
    message('Error: No ID specified.', 'contacts.php', true);
}

?>

<?= template_header('Contact Update') ?>
<?= template_nav(isset($_SESSION['loggedin'])) ?>

<!-- START PAGE CONTENT -->
<div class = "columns">
    <!-- START LEFT NAV COLUMN-->
    <?= template_menu(isset($_SESSION['loggedin'])) ?>
    <div class = "column" >
        <h1 class="title">Contact Update</h1>

        <form action="contact-update.php?id=<?=$contact['id']?>" method="POST">
            <div class="field">
                <label class="label">Name</label>
                <div class="control">
                    <input type="text" name="name" class="input" value="<?=$contact['name']?>" required>
                </div>
            </div>
            <div class="field">
                <label class="label">Email</label>
                <div class="control">
                    <input type="email" name="email" class="input" value="<?=$contact['email']?>" required>
                </div>
            </div>
            <div class="field">
                <label class="label">Phone</label>
                <div class="control">
                    <input type="tel" name="phone" class="input" value="<?=$contact['phone']?>" required>
                </div>
            </div>
            <div class="field">
                <label class="label">Title</label>
                <div class="control">
                    <input type="text" name="title" class="input" value="<?=$contact['title']?>" required>
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