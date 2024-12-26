<?php
// db.php

$servername = "localhost"; // Change if your DB is hosted elsewhere
$username = "root"; // Replace with your DB username
$password = ""; // Replace with your DB password
$dbname = "dbf0oxtaz1iwqa";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
