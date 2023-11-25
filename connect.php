<?php
$server = "localhost";
$username = "root";
$password = "";  // By default, XAMPP has no password for the root user
$database = "remote_work_collaborator";

// Create a connection
$conn = new mysqli($server, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>