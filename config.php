<?php
// Insert database credentials into variables
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'rubixgames');
 
// Attempt to use given variables to connect to MySQL database
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check for unsuccesful connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>