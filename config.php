<?php
// config.php
define('DB_HOST', 'www.tngqatar.online');
define('DB_USERNAME', 'tngqatar_GuestUser');
define('DB_PASSWORD', '4TNG@QatarDemo');
define('DB_NAME', 'tngqatar_AppDev');

function getDbConnection() {
    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    return $conn;
}
?>