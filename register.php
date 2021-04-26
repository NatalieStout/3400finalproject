<?php
require 'config.php';

session_start();

$msg = "";
$err = false;
$success = "";

if (isset($_GET['msg'], $_GET['err'])) {
    $msg = $_GET['msg'];
    $err = $_GET['err'];
}

// Now we check if the data was submitted, isset() function will check if the data exists.
if (isset($_POST['username'], $_POST['password'], $_POST['email'])){
    // We need to check if the account with that username exists.
    if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
        // Bind parameters (s = string, i = int, b = blob, etc.), has the password using the PHP password_hash function
        $stmt->bind_param('s', $_POST['username']);
        $stmt->execute();
        $stmt->store_result();
        // Store the result so we can check if the account exists in the database.
        if ($stmt->num_rows() > 0) {
            // Username already exists
            message('Username exists, please choose another!', 'register.php', true);
        } else {
            // Username doesn't exist, insert new account
            if ($stmt = $con->prepare('INSERT INTO accounts (username, password, email, activation_code) VALUES (?, ?, ?, ?)')) {
                // We do not want to expose passwords in our database, so hash password and use password_verify when a user logs in.
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $uniqid = uniqid();
                $stmt->bind_param('ssss', $_POST['username'], $password, $_POST['email'], $uniqid);
                $stmt->execute();
                // Send confirmation email.
                $from = 'randiweston@weber.edu';
                $subject = 'Account activation required';
                $headers = 'From: ' . $from . "\r\n" . 'Reply-To: ' . $from . "\r\n" 
                                    . 'X-Mailer: PHP/' . phpversion() . "\r\n"
                                    . 'MIME-Version: 1.0' . "\r\n"
                                    . 'Content-Type: text/html; charset=UTF-8' . "\r\n";
                $activate_link = 'http://icarus.cs.weber.edu/~rw72093/web3400/project6/activate.php?email=' . $_POST['email'] . '&code=' . $uniqid;
                $message = '<p>Please click the following link to activate your account: <a href="' . $activate_link . '">' . $activate_link . '</a></p>';
                // echo "<a href='$activate_link'>$activate_link</a>";
                message("Success! Please check your email to activate your account.", 'register.php', false);
            } else {
                // Something went wrong with the sql statement, check to make sure accounts table exists with all 3 fields
                message('Error: Could not prepare statement!', 'register.php', true);
            }
        }
        $stmt->close();
    } else {
        message('Error: Could not prepare statement!', 'register.php', true);
    }
    $con->close();
}

?>

<?= template_header('Register') ?>
<?= template_nav(isset($_SESSION['loggedin'])) ?>

    <!-- START PAGE CONTENT -->
    <?php if ($msg && !$err) : ?>
        <div class="notification is-success is-light py-2">
            <p><strong><?php echo $msg; ?></strong></p>
        </div>
    <?php elseif ($msg && $err) : ?>
        <div class="notification is-danger is-light py-2">
            <p><strong><?php echo $msg; ?></strong></p>
        </div>
    <?php endif; ?>
    <h1 class="title">Register</h1>
    <form action="register.php" method="POST">
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
            <p class="control has-icons-left">
                <input name="email" class="input" type="text" placeholder="Email" required>
                <span class="icon is-small is-left">
                    <i class="far fa-envelope"></i>
                </span>
            </p>
            </div>
            <div class="field">
            <p class="control">
                <button class="button is-success">
                Register
                </button>
            </p>
        </div>
    </form>
    <!-- END PAGE CONTENT -->

<?= template_footer() ?>