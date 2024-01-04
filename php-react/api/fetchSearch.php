<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);

// Include config file
require_once "../config/database.php";

$data = json_decode(file_get_contents("php://input"), true);

$names = "";
$tels = "";
$age = "";
$mailAllowed = "";
$lastUsedDate = "";
$lastUsedDateBeforeOrAfter = "";
$visitedTimes = "";
$visitedLowerOrHeigher = "";
$visitedLowerOrHeigher = "";
$amount = "";
$amountLowerOrHigher = "";

if (isset( $data["names"] ) ) { $names = $data["names"]; }
if (isset ( $data["tels"] ) ) { $tels = $data["tels"]; }
if (isset ( $data["age"] ) ) { $age = $data["age"]; }
if (isset ( $data["mailAllowed"] ) ) { $mailAllowed = $data["mailAllowed"]; }
if (isset ( $data["lastUsedDate"] ) ) { $lastUsedDate = $data["lastUsedDate"]; }
if (isset ( $data["lastUsedDateBeforeOrAfter"] ) ) { $lastUsedDateBeforeOrAfter = $data["lastUsedDateBeforeOrAfter"]; }
if (isset ( $data["visitedTimes"] ) ) { $visitedTimes = $data["visitedTimes"]; }
if (isset ( $data["visitedLowerOrHeigher"] ) ) { $visitedLowerOrHeigher = $data["visitedLowerOrHeigher"]; }
if (isset ( $data["amount"] ) ) { $amount = $data["amount"]; }
if (isset ( $data["amountLowerOrHigher"] ) ) { $amountLowerOrHigher = $data["amountLowerOrHigher"]; }

$sql = 'SELECT * FROM client_info WHERE first_name IN (".$names.") = ' . $clientId . ' limit 1;';

$result = mysqli_query($conn, $sql);

while ($data = $result->fetch_assoc())
{
    $rows[] = $data;
}
echo json_encode($rows, JSON_UNESCAPED_UNICODE, JSON_NUMERIC_CHECK);

mysqli_close($conn);
