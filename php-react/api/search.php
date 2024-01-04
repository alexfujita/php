<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);

// Include config file
require_once "../config/database.php";

$data = json_decode(file_get_contents("php://input"), true);

$names = "";
$tels = "";
$range = "";
$dateFrom = "";
$dateTo = "";
$mailAllowed = "";
$lastUsedDate = "";
$lastUsedDateBeforeOrAfter = "";
$visitedTimes = "";
$visitedLowerOrHeigher = "";
$visitedLowerOrHeigher = "";
$amount = "";
$amountLowerOrHigher = "";

$sql = " SELECT id, last_name, first_name, IFNULL(tel, cel) AS phone, birthday FROM client_info WHERE id IS NOT NULL ";

if (isset( $data["names"]) && $data["names"] !== "" ) { 
    $names = $data["names"]; 
    $names = implode("|", $names);
    $names = "'$names'";
    $sql .= " AND (last_name REGEXP $names OR first_name REGEXP $names) ";
}

if (isset ( $data["tels"] ) && $data["tels"] !== "") { 
    $tels = $data["tels"]; 
    $tels = implode("|", $tels);
    $tels = "'$tels'";
    $sql .= " AND (tel REGEXP $tels OR cel REGEXP $tels) ";
}
if (isset ( $data["range"] ) && $data["range"] !== "" ) {
    $range = $data["range"]; 
    $dateFrom = $data["dateFrom"];
    $dateTo = $data["dateTo"];
    $sql .= " AND birthday BETWEEN '$dateFrom' AND '$dateTo' ";
}

$result = mysqli_query($conn, $sql);
$rows = [];
while ($data = $result->fetch_assoc()) { $rows[] = $data; }
echo json_encode($rows, JSON_UNESCAPED_UNICODE, JSON_NUMERIC_CHECK);
mysqli_close($conn);