<?php
// edge-tech_moving DB');
define('DB_USERNAME', 'xxx');
define('DB_PASSWORD', 'xxx');
define('DB_NAME', 'xxx');
 
// Connection to database
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
$conn->set_charset('utf8');
// Check connection
if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>