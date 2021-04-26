<?php
require 'config.php';

session_start();

$msg = "";
$err = false;

if (isset($_GET['msg'], $_GET['err'])) {
    $msg = $_GET['msg'];
    $err = $_GET['err'];
}

?>

<?= template_header('Login') ?>
<?= template_nav(isset($_SESSION['loggedin'])) ?>

    <!-- START PAGE CONTENT -->
    <?php if ($msg && $err) : ?>
        <div class="notification is-danger is-light px-0 py-2">
            <p class="has-text-danger ml-3"><strong><?php echo $msg; ?></strong></p>
        </div>
    <?php endif; ?>
    <h1 class="title">Login</h1>
    <?php if ($msg && $msg == "empty") : ?>
        <div class="notification is-warning is-light px-0 py-2">
            <p class="has-text-warning ml-3"><strong><?php echo $msg_content; ?></strong></p>
        </div>
    <?php endif; ?>
    <form action="authenticate.php" method="POST">
        <div class="field">
            <p class="control has-icons-left">
                <input name="username" class="input" type="text" placeholder="Username" required>
                <span class="icon is-small is-left">
                    <i class="fas fa-user"></i>
                </span>
            </p>
        </div>
        <div class="field">
            <p class="control has-icons-left">
                <input name="password" class="input" type="password" placeholder="Password" required>
                <span class="icon is-small is-left">
                    <i class="fas fa-lock"></i>
                </span>
            </p>
        </div>
        <div class="field">
            <p class="control">
                <button class="button is-success">
                Login
                </button>
            </p>
        </div>
    </form>
    <p class="mt-5">
        <a href="register.php" class="button is-link is-small" title="Sign Up"><span class="icon mr-1"><i class="fas fa-user-plus"></i></span> Sign Up</a>
        <a href="#" class="button is-link is-small" title="Forgot Password"><span class="icon mr-1"><i class="fas fa-key"></i></span> Forgot Password</a>
        <a href="contact.php" class="button is-link is-small" title="Need Help">Need Help <span class="icon ml-1"><i class="fas fa-question-circle"></i></span></a>
    </p>
    <!-- END PAGE CONTENT -->

<?= template_footer() ?>