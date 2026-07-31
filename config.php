<?php
/**
 * config.php
 * Database connection settings.
 * Update the values below to match your MySQL database
 * (either your local XAMPP setup or your InfinityFree account).
 */

// ---- Local XAMPP settings (active by default) ----
$db_host = "localhost";
$db_user = "root";
$db_pass = "";                 // empty by default in XAMPP
$db_name = "studentdb";        // must match the database name you created in phpMyAdmin

// ---- InfinityFree settings (uncomment and fill in when deploying online) ----
// $db_host = "sqlXXX.infinityfree.com";
// $db_user = "if0_XXXXXXXX";
// $db_pass = "your_password_here";
// $db_name = "if0_XXXXXXXX_studentdb";

// Create the connection using mysqli
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Stop and show an error if the connection fails
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Set character encoding (supports English and Arabic text)
$conn->set_charset("utf8mb4");
?>