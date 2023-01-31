<?php
// Insert database credentials into variables
define('DB_SERVER_2', 'localhost');
define('DB_USERNAME_2', 'root');
define('DB_PASSWORD_2', '');
define('DB_NAME_2', 'tennis');
 
// Attempt to use given variables to connect to MySQL database
$link = mysqli_connect(DB_SERVER_2, DB_USERNAME_2, DB_PASSWORD_2, DB_NAME_2);
 
// Check for unsuccesful connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>