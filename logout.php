<?php
// Logout script
session_start();
session_destroy();

// Redirect to homepage
header('Location: login.php');

?>
