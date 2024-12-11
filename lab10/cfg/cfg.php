<?php
    // config.php (Use environment variables)
    $dbhost = getenv('DB_HOST') ?: 'localhost';
    $dbuser = getenv('DB_USER') ?: 'root';
    $dbpass = getenv('DB_PASS') ?: '';
    $dbname = getenv('DB_NAME') ?: 'moja_strona';
    
    $login = getenv('adminlogin') ?: 'admin';
    $pass = getenv('adminpass') ?: 'admin';


    $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

    if ($mysqli->connect_error) {
        // Log the error
        error_log("Connection failed: " . $mysqli->connect_error);
        // Show user-friendly message
        exit("Database connection error. Please try again later.");
    }
    
?>
