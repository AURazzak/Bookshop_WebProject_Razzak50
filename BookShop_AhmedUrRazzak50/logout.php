<?php
session_start();

// Destroy the session to log the user out
session_destroy();

// Redirect to the login page (index.php)
header('Location: index.php');
exit;
?>
