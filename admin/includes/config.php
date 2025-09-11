<?php
// filepath: config.php

// Load environment variables (use a library like vlucas/phpdotenv or set them in your server config)
define('DB_SERVER', getenv('DB_SERVER') ?: 'localhost');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');
define('DB_NAME', getenv('DB_NAME') ?: 'belleville-dental');

// Establish database connection
$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

// Check connection
if (!$con) {
    // Log the error instead of displaying it
    error_log("Database connection failed: " . mysqli_connect_error());
    die("Database connection error. Please try again later.");
}

// Set the character set
mysqli_set_charset($con, 'utf8mb4');