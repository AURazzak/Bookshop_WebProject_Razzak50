<?php
$host = 'localhost'; // Your database host
$username = 'root';  // Your database username
$password = '';      // Your database password (empty for default in XAMPP)
$dbname = 'book_shop'; // Your database name

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
