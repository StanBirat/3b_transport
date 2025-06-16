<?php
$host = "localhost";       // or 127.0.0.1
$user = "root";            // your MySQL username (default is 'root' for XAMPP)
$password = "";            // your MySQL password (default is empty for XAMPP)
$database = "3b_transport"; // your database name

$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>
