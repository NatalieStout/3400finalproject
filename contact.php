<?php
require 'config.php';

session_start();

//additional php code for this page goes here
$response = '';

if (isset($_POST['email'], $_POST['name'], $_POST['subject'], $_POST['msg'])) {
    //var_dump($_POST);
    //send email
    $to      = "randiweston@weber.edu";
    $from    = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['msg'];
    $headers = 'From: ' . $_POST['email'] . "\r\n" . 'Reply-To: ' . $_POST['email'] . "\r\n" . 'X-Mailer: PHP/' . phpversion();
    mail($to, $subject, $message, $headers);
    
    //update response
    $response = 'Message sent!';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    <script src="js/bulma.js"></script>
    <title>Contact us</title>
</head>

<?= template_header('Home') ?>
<?= template_nav(isset($_SESSION['loggedin'])) ?>

    <!-- START PAGE CONTENT -->
    <h1 class="title">Contact us</h1>
    <!-- message sent confirmation goes here -->
    <?php if ($response) : ?>
        <div class="notification is-success">
        <h2 class="title is-2"><?php echo $response; ?></h2>
        </div>
    <?php endif; ?>

    <form action="" method="post">
        <div class="field">
            <label class="label">Email</label>
            <div class="control has-icons-left">
                <input class="input" type="email" placeholder="your@email.com" name="email">
                <span class="icon is-small is-left">
                    <i class="fas fa-at"></i>
                </span>
            </div>
        </div>
        <div class="field">
            <label class="label">Name</label>
            <div class="control">
                <input class="input" type="text" placeholder="Your Name" name="name">
            </div>
        </div>
        <div class="field">
            <label class="label">Message Subject</label>
            <div class="control">
                <input class="input" type="text" placeholder="Subject" name="subject">
            </div>
        </div>
        <div class="field">
            <label class="label">Message</label>
            <div class="control">
                <textarea class="textarea" placeholder="What would you like to contact us about?" name="msg"></textarea>
            </div>
        </div>
        <div class="field">
            <div class="control">
                <button class="button is-link">
                    <span class="icon">
                        <i class="fas fa-paper-plane"></i>
                    </span>
                    <span>Send Message</span>
                </button>
            </div>
        </div>
    </form>

    <!-- END PAGE CONTENT -->

<?= template_footer() ?>