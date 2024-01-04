<?php

ini_set("display_errors", 1);
error_reporting(E_ALL);

$data = json_decode(file_get_contents("php://input"), true);

// Include config file
require_once "../config/database.php";

// Define variables and initialize with empty values
// 変数を定義、初期値設定
$id = 0;
$ownerStatus = "";
$agencyName = "";
$agencyPostalCode = "";
$agencyAddress1 = "";
$agencyAddress2 = "";
$agencyAddress3 = "";
$agencyAddress4 = "";
$agencyTel = "";
$agencyFax = "";
$agencyBankName = "";
$agencyBankCode = "";
$agencyBranchName = "";
$agencyBranchCode = "";
$agencyAccountType = "";
$agencyAccountNr = "";
$agencyAccountName = "";
$userCode = "";
$useStatus = "";

$values = [
    "id",
    "ownerStatus",
    "agencyName",
    "agencyPostalCode",
    "agencyAddress1",
    "agencyAddress2",
    "agencyAddress3",
    "agencyAddress4",
    "agencyTel",
    "agencyFax",
    "agencyBankName",
    "agencyBankCode",
    "agencyBranchName",
    "agencyBranchCode",
    "agencyAccountType",
    "agencyAccountNr",
    "agencyAccountName",
    "userCode",
    "useStatus"
];

foreach( $values as $value ) {
    if ( isset( $data[$value] ) ) {
        $$value = $data[$value];
    } else if (empty( $data[$value] ) ) {
        $$value = NULL;
    }
}
// Processing form data when form is submitted
// 送信データ実行処理

if( $_SERVER["REQUEST_METHOD"] == "POST" ) {
    // Check connection
    if (mysqli_connect_errno())
    {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $sql_insert = 
        "INSERT INTO agency_info (
            user_cd,
            owner_status,
            use_status,
            agency_name,
            agency_postal_cd,
            agency_address_01,
            agency_address_02,
            agency_address_03,
            agency_address_04,
            agency_tel_no,
            agency_fax_no,
            bank_cd,
            store_cd,
            deposits_event,
            account_no,
            account_name,
            bank_name,
            store_name
        ) VALUES (
            '$userCode',
            '$ownerStatus',
            '$useStatus',
            '$agencyName',
            '$agencyPostalCode',
            '$agencyAddress1',
            '$agencyAddress2',
            '$agencyAddress3',
            '$agencyAddress4',
            '$agencyTel',
            '$agencyFax',
            '$agencyBankCode',
            '$agencyBranchCode',
            '$agencyAccountType',
            '$agencyAccountNr',
            '$agencyAccountName',
            '$agencyBankName',
            '$agencyBranchName'
        )"
    ;

    $sql_update = "
        UPDATE
            agency_info
        SET
            user_cd = '$userCode',
            owner_status = '$ownerStatus',
            use_status = '$useStatus',
            agency_name = '$agencyName',
            agency_postal_cd = '$agencyPostalCode',
            agency_address_01 = '$agencyAddress1',
            agency_address_02 = '$agencyAddress2',
            agency_address_03 = '$agencyAddress3',
            agency_address_04 = '$agencyAddress4',
            agency_tel_no = '$agencyTel',
            agency_fax_no = '$agencyFax',
            bank_cd = '$agencyBankCode',
            store_cd = '$agencyBranchCode',
            deposits_event = '$agencyAccountType',
            account_no = '$agencyAccountNr',
            account_name = '$agencyAccountName',
            bank_name = '$agencyBankName',
            store_name = '$agencyBranchName'
        WHERE id = '$id'    
    ";

    // echo $sql_insert;

    is_null($id) ? $id = 0 : $id = $id;
    $sql = "SELECT * FROM agency_info WHERE id = $id";
    $query = mysqli_query($conn, $sql);
    $num_rows = mysqli_num_rows($query);

     if ($num_rows > 0) {
        mysqli_query($conn, $sql_update);
    } else {
        mysqli_query($conn, $sql_insert);
    }

    if (mysqli_query($conn, $sql_update) == 1)  {
        echo "success";
    } else if (mysqli_query($conn, $sql_insert) == 1) {
        echo "success";
    }
    else {
        echo "failed";
    }

    mysqli_close($conn);

}