<?php
// Include config file
require_once "../config/database.php";

$data = json_decode(file_get_contents("php://input"), true);

$id = "";
if ( isset( $data["id"] ) ) {
    $id = $data["id"];
}
$sql = 'SELECT * FROM client_info WHERE id = ' . $id . ' limit 1;';

$result = mysqli_query($conn, $sql);

while ($data = $result->fetch_assoc())
{
    $rows[] = $data;
}
echo json_encode($rows, JSON_UNESCAPED_UNICODE, JSON_NUMERIC_CHECK);

mysqli_close($conn);
