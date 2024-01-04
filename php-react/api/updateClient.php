<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);

$data = json_decode(file_get_contents("php://input"), true);

// Include config file
require_once "../config/database.php";

// Define variables and initialize with empty values
// 変数を定義、初期値設定
$id = 0;
$tel = "";
$cel = "";
$lastName = "";
$firstName = "";
$lastNameKana = "";
$firstNameKana = "";
$genre = "";
$birthdate = "";
$postalCode = "";
$address1 = "";
$address2 = "";
$address3 = "";
$address4 = "";
$email = "";
$insuranceType = "";
$ratio = "";
$agreement = "";

$values = [
    "id",
    "tel",
    "cel",
    "lastName",
    "firstName",
    "lastNameKana",
    "firstNameKana",
    "genre",
    "birthdate",
    "postalCode",
    "address1",
    "address2",
    "address3",
    "address4",
    "email",
    "insuranceType",
    "ratio",
    "agreement"
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

    // Perform query
    $sql_insert =
        "INSERT INTO client_info (
            tel,
            cel,
            last_name,
            first_name,
            last_name_kana,
            first_name_kana,
            genre,
            birthday,
            postal_code,
            address1,
            address2,
            address3,
            address4,
            email,
            insurance_type,
            burden_ratio,
            personal_info_agreement
        ) VALUES (
            '$tel',
            '$cel',
            '$lastName',
            '$firstName',
            '$lastNameKana',
            '$firstNameKana',
            '$genre',
            " . ($birthdate === NULL || $birthdate === "" ? "NULL" : "'$birthdate'") . ",
            '$postalCode',
            '$address1',
            '$address2',
            '$address3',
            '$address4',
            '$email',
            '$insuranceType',
            '$ratio',
            " . ($agreement === NULL || $agreement ===  "" ? "NULL" : "'$agreement'") . "
        )"
    ;

    $sql_update = "
        UPDATE 
            client_info
        SET
            tel = '$tel',
            cel = '$cel',
            last_name = '$lastName',
            first_name = '$firstName',
            last_name_kana = '$lastNameKana',
            first_name_kana = '$firstNameKana',
            genre = '$genre',
            birthday = '$birthdate',
            postal_code = '$postalCode',
            address1 = '$address1',
            address2 = '$address2',
            address3 = '$address3',
            address4 = '$address4',
            email = '$email',
            insurance_type = '$insuranceType',
            burden_ratio = '$ratio',
            personal_info_agreement = '$agreement'
        WHERE id = '$id'    
    ";

    echo $sql_insert;

    $sql = "SELECT * FROM client_info WHERE id = $id";

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