<?php
// Database server details
$server = "localhost";
$user = "root";
$password = "";
$db = "sweddeco";

// Establishing a new database connection
$conn = mysqli_connect($server, $user, $password, $db);

// Checking if the connection was successful
if (!$conn) {
    // Connection failed, terminate the script
    die("Connection Failed: " . mysqli_connect_error());
}
