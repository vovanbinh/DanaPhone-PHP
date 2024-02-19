<?php
$servername = "localhost"; // Replace with your database server name
$usernamedb = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "projectPHP"; // Replace with your database name
$conn = new mysqli($servername, $usernamedb, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>