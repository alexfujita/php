<?php
// Include config file
require_once "../config/database.php";

$data = json_decode(file_get_contents("php://input"), true);

$clientId = "";
if ( isset( $data["clientId"] ) ) {
    $clientId = $data["clientId"];
}
$sql = 'SELECT * FROM moving_info WHERE id = ' . $clientId . ' limit 1;';

$result = mysqli_query($conn, $sql);

while ($data = $result->fetch_assoc())
{
    $rows[] = $data;
}
echo json_encode($rows, JSON_UNESCAPED_UNICODE, JSON_NUMERIC_CHECK);

mysqli_close($conn);
