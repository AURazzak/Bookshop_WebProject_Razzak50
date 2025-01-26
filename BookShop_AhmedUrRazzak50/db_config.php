<?php
$servername = "localhost";
$username = "root"; // Default username for MySQL in XAMPP
$password = ""; // Default password for MySQL in XAMPP
$dbname = "book_shop"; // Name of your database

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
