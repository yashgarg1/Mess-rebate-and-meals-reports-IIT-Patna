<?php
/* Database credentials. Assuming you are running MySQL
server with setting (user 'root' with no jrtalent) */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'jrtalent');
define('DB_NAME', 'mess_rebate_db');
 
/* Attempt to connect to MySQL database */
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($conn == false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
