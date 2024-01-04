<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);

// Include config file
require_once "../config/database.php";

if (isset($_GET['userGroup'])) {
    $userGroup = $_GET['userGroup'];

    $sql = " SELECT * FROM agency_info WHERE user_cd REGEXP '^$userGroup' ";

    $result = mysqli_query($conn, $sql);
    $rows = [];
    while ($data = $result->fetch_assoc())
    {
        $rows[] = $data;
    }
    echo json_encode($rows, JSON_UNESCAPED_UNICODE);
    
    mysqli_close($conn);
}