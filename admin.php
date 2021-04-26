<?php
require 'config.php';

session_start();


if(!isset($_SESSION['loggedin'])){
    // header('Location: login.php');
    message("Please login first.", "login.php", true);
    exit;
}

// query the database
$stmt = $con->prepare('SELECT password, email FROM accounts WHERE id = ?');
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($password, $email);
$stmt->fetch();
$stmt->close();

?>

<?= template_header('Admin') ?>
<?= template_nav(isset($_SESSION['loggedin'])) ?>

<div class = "columns">
  <!-- START LEFT NAV COLUMN-->
  <?= template_menu(isset($_SESSION['loggedin'])) ?>
    <!-- START PAGE CONTENT -->
    <div class = "column" >
    <h1 class = "title" > Admin Page </h1>
      <p class = "has-background-link-light subtitle"> Your account details are below. </p>

      <div class="card">
  <div class="card-content">
    <div class="media">
      <div class="media-left">
        <figure class="image is-48x48">
          <img src="https://bulma.io/images/placeholders/96x96.png" alt="Placeholder image">
        </figure>
      </div>
      <div class="media-content">
        <p class="title is-4"><?=$_SESSION['name']?></p>
        <p class="subtitle is-6"><?=$email?></p>
      </div>
    </div>
    <div class="content">
    <?=$password?>
      <br>
    </div>
  </div>

    </div>
</div>


<?= template_footer() ?>
