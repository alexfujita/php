<?php
// edge-tech_moving DB
define('DB_SERVER', '127.0.0.1');
define('DB_USERNAME', 'xxx');
define('DB_PASSWORD', 'xxx');
define('DB_NAME', 'xxx');
 
// Connection to database
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>