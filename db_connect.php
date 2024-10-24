<?php
// Database connection details
$dbHost = 'localhost'; // Database host
$dbUser = 'root';      // Database username
$dbPass = '';          // Database password
$dbName = 'dbc1'; // Database name

// Create connection
$db = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
?>
