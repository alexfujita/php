<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);

// Include config file
require_once "../config/database.php";

$data = json_decode(file_get_contents("php://input"), true);

$startOfMonth = $endOfMonth = "";
if ( isset( $data['startOfMonth'] ) ) {
    $startOfMonth = $data['startOfMonth'];
}
if ( isset( $data['endOfMonth'] ) ) {
    $endOfMonth = $data['endOfMonth'];
}


$sql = 'SELECT id, last_name, first_name, moving_date FROM moving_info WHERE moving_date BETWEEN "'.$startOfMonth.'" AND "'.$endOfMonth.'" ORDER BY moving_date DESC;';

$result = mysqli_query($conn, $sql);
$rows = [];
while ($data = $result->fetch_assoc())
{
    $rows[] = $data;
}
echo json_encode($rows, JSON_UNESCAPED_UNICODE);

mysqli_close($conn);