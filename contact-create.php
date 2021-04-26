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
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $created = isset($_POST['created']) ? $_POST['created'] : date('Y-m-d H:i:s');
    
    // Insert the new contact record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO contacts VALUES (NULL, ?, ?, ?, ?, ?)');
    $stmt->execute([$name, $email, $phone, $title, $created]);

    // $msg = "Contact created successfully!";
    message('Contact created successfully!', 'contacts.php', false);
}

?>

<?= template_header('Create Contact') ?>
<?= template_nav(isset($_SESSION['loggedin'])) ?>

<div class = "columns">
    <!-- START LEFT NAV COLUMN-->
    <?= template_menu(isset($_SESSION['loggedin'])) ?>
    <!-- START PAGE CONTENT -->
    <div class = "column" >
        <!-- START PAGE CONTENT -->
        <h1 class="title">Create Contact</h1>

        <form action="" method="POST">
            <div class="field">
                <label class="label">Name</label>
                <div class="control">
                    <input class="input" type="text" name="name" placeholder="Contact Name" required>
                </div>
            </div>
            <div class="field">
                <label class="label">Email</label>
                <div class="control">
                    <input class="input" type="email" name="email" placeholder="Contact Email">
                </div>
            </div>
            <div class="field">
                <label class="label">Phone</label>
                <div class="control">
                    <input class="input" type="tel" name="phone" placeholder="Contact Phone">
                </div>
            </div>
            <div class="field">
                <label class="label">Title</label>
                <div class="control">
                    <input class="input" type="text" name="title" placeholder="Contact Title">
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