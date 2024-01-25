<?php
// Database connection details
$host = "localhost";       // Hostname of the database server
$user = "root";            // Database username
$password = "";            // Database password
$database = "test_db";     // Database name
// Create a new mysqli object for establishing a database connection
$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    // If connection fails, terminate the script and display an error message
    die("Connection failed: " . $conn->connect_error);
}
?>
