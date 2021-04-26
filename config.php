<?php
// Change this to your connection info.
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'W01340980';
$DATABASE_PASS = 'Nataliecs!';
$DATABASE_NAME = 'W01340980';
// Try and connect using the info above.
  $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
  if (mysqli_connect_errno()) {
    // If there is an error with the connection, stop the script and display the error.
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
  }

function pdo_connect_mysql() {
  // db connection constants
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'W01340980';
$DATABASE_PASS = 'Nataliecs!';
$DATABASE_NAME = 'W01340980';

  // db connection
  try {
    return new PDO(
      'mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8' ,
      $DATABASE_USER, 
      $DATABASE_PASS
    );
  } catch (PDOException $exception) {
    die ('Failed to connect to the database.');
  }
}

function message($message, $action, $err)
{
  header("Location: " . $action . "?msg=" . $message . "&err=" . $err);
}

function template_header($title = "Page title")
{
echo <<<EOT
 <!DOCTYPE html>
  <html>

    <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>$title</title>
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">
     <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
     <script defer src="js/bulma.js"></script>
    </head>

  <body>
EOT;
}

function template_nav($session)
{
echo <<<EOT
  <!-- START NAV -->
    <nav class="navbar is-light">
      <div class="container">
        <div class="navbar-brand">
          <a class="navbar-item" href="index.php">
            <span class="icon is-large">
              <i class="fas fa-home"></i>
            </span>
            <span>Home</span>
          </a>
          <div class="navbar-burger burger" data-target="navMenu">
            <span></span>
            <span></span>
            <span></span>
          </div>
        </div>
        <div id="navMenu" class="navbar-menu">
          <div class="navbar-start">
            <!-- navbar link go here -->
          </div>
          <div class="navbar-end">
            <div class="navbar-item">
              <div class="buttons">
EOT;
                if ($session == true) {
                  echo <<<EOT
                  <a href="admin.php" class="button">
                    <span class="icon"><i class="fas fa-user"></i></span>
                    <span>Admin</span>
                  </a>
                  EOT;
                }
                echo <<<EOT
                <a href="contact.php" class="button">
                  <span class="icon"><i class="fas fa-address-book"></i></span>
                  <span>Contact Us</span>
                </a>
                EOT;
                if ($session == true) {
                  echo <<<EOT
                  <a href="logout.php" class="button">
                    <span class="icon"><i class="fas fa-sign-out-alt"></i></span>
                    <span>Logout</span>
                  </a>
                  EOT;
                } else if ($session == false) {
                  echo <<<EOT
                  <a href="login.php" class="button">
                    <span class="icon"><i class="fas fa-sign-out-alt"></i></span>
                    <span>Login</span>
                  </a>
                  EOT;
                }
echo <<<EOT
            </div>
          </div>
        </div>
      </div>
    </div>
  </nav>
  <!-- END NAV -->

  <!-- START MAIN -->
  <section class="section">
      <div class="container">
EOT;
}

function template_menu($session)
{
  if ($session == true) {
    echo <<<EOT
    <div class = "column is-one-quarter">
      <aside class = "menu">
        <p class = "menu-label"> Admin menu </p>
          <ul class = "menu-list">
          <li ><a href = "admin.php"> Admin </a></li>
          <li ><a href = "profile.php" > Profile </a></li>
          <li ><a href = "polls.php" > Polls </a></li>
          <li ><a href = "contacts.php"> Contacts </a></li>
          <li ><a href = "blog-admin.php"> Blog </a></li>
          <li ><a href = "reviews-admin.php"> Reviews </a></li>
          </ul >
      </aside >
    </div >
  EOT;
}
}

function template_footer()
{
echo <<<EOT
        </div>
    </section>
    <!-- END MAIN-->

    <!-- START FOOTER -->
    <footer class="footer">
        <div class="container">
            <p>Footer content goes here</p>
        </div>
    </footer>
    <!-- END FOOTER -->
    </body>
  </html>
EOT;
}