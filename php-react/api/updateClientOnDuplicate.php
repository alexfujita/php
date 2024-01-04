<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);

$data = json_decode(file_get_contents("php://input"), true);

// Include config file
require_once "../config/database.php";

// Define variables and initialize with empty values
// 変数を定義、初期値設定
$lastName = "";
$firstName = "";
$lastNameKana = "";
$firstNameKana = "";
$genre = 0;
$birthDate = "";
$email = "";
$tel1 = "";
$tel2 = "";
$carrier = "";
$contactable = 0;
$contactableTimeFrom1 = "";
$contactableTimeTo1 = "";
$contactableDate1 = "";
$contactableDate2 = "";
$contactableTimeFrom2 = "";
$contactableTimeTo2 = "";
$actualPostalCode = "";
$actualAddress1 = "";
$actualAddress2 = "";
$actualAddress3 = "";
$actualInfra = 0;
$movingDate = "NULL";
$movingPostalCode = "";
$movingAddress1 = "";
$movingAddress2 = "";
$movingAddress3 = "";
$electrical = false;
$cityGas = false;
$propaneGas = false;
$water = false;
$internet = false;
$oaEquipment = false;
$hpSecurity = false;
$waterServer = false;
$electricalStatus = 0;
$gasStatus = 0;
$internetStatus = 0;
$homeSecurityStatus = 0;
$memo = "";

$postValues = [
 "lastName",
 "firstName",
 "lastNameKana",
 "firstNameKana",
 "genre",
 "birthDate",
 "email",
 "tel1",
 "tel2",
 "carrier",
 "contactable",
 "contactableTimeFrom1",
 "contactableTimeTo1",
 "contactableDate1",
 "contactableDate2",
 "contactableTimeFrom2",
 "contactableTimeTo2",
 "actualPostalCode",
 "actualAddress1",
 "actualAddress2",
 "actualAddress3",
 "actualInfra",
 "movingDate",
 "movingPostalCode",
 "movingAddress1",
 "movingAddress2",
 "movingAddress3",
 "electrical",
 "internet",
 "cityGas",
 "oaEquipment",
 "propaneGas",
 "hpSecurity",
 "water",
 "waterServer",
 "electricalStatus",
 "gasStatus",
 "internetStatus",
 "homeSecurityStatus",
 "memo"
];

foreach( $postValues as $postValue ) {
    if ( isset( $data[$postValue] ) ) {
        $$postValue = $data[$postValue];
    } else if (empty( $data[$postValue] ) ) {
        $$postValue = NULL;
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
    $sql =  
        "INSERT INTO clients (
            person_in_charge,
            client_status,
            first_name,
            last_name,
            first_name_kana,
            last_name_kana,
            genre,
            birthday,
            email,
            tel_1,
            tel_2,
            carrier,
            contactable,
            contactable_date_1,
            contactable_time_from_1,
            contactable_time_to_1,
            contactable_date_2,
            contactable_time_from_2,
            contactable_time_to_2,
            actual_postal_code,
            actual_address_1,
            actual_address_2,
            actual_address_3,
            moving_postal_code,
            moving_address_1,
            moving_address_2,
            moving_address_3,
            moving_date,
            electrical,
            city_gas,
            propane_gas,
            water,
            internet,
            oa_equipment,
            hp_security,
            water_server,
            electrical_status,
            gas_status,
            internet_status,
            home_security_status,
            memo
        ) VALUES (
            null,
            null,
            '$firstName',
            '$lastName',
            '$firstNameKana',
            '$lastNameKana',
            '$genre',
            " . ($birthDate == NULL ? "NULL" : "'$birthDate'") . ",
            '$email',
            '$tel1',
            '$tel2',
            '$carrier',
            '$contactable',
            '$contactableDate1',
            '$contactableTimeFrom1',
            '$contactableTimeTo1',
            '$contactableDate2',
            '$contactableTimeFrom2',
            '$contactableTimeTo2',
            '$actualPostalCode',
            '$actualAddress1',
            '$actualAddress2',
            '$actualAddress3',
            '$movingPostalCode',
            '$movingAddress1',
            '$movingAddress2',
            '$movingAddress3',
            " . ($movingDate==NULL ? "NULL" : "'$movingDate'") . ",
            '$electrical',
            '$cityGas',
            '$propaneGas',
            '$water',
            '$internet',
            '$oaEquipment',
            '$hpSecurity',
            '$waterServer',
            '$electricalStatus',
            '$gasStatus',
            '$internetStatus',
            '$homeSecurityStatus',
            '$memo'
        )
        ON DUPLICATE KEY UPDATE 
            person_in_charge,
            client_status,
            first_name,
            last_name,
            first_name_kana,
            last_name_kana,
            genre,
            birthday,
            email,
            tel_1,
            tel_2,
            carrier,
            contactable,
            contactable_date_1,
            contactable_time_from_1,
            contactable_time_to_1,
            contactable_date_2,
            contactable_time_from_2,
            contactable_time_to_2,
            actual_postal_code,
            actual_address_1,
            actual_address_2,
            actual_address_3,
            moving_postal_code,
            moving_address_1,
            moving_address_2,
            moving_address_3,
            moving_date,
            electrical,
            city_gas,
            propane_gas,
            water,
            internet,
            oa_equipment,
            hp_security,
            water_server,
            electrical_status,
            gas_status,
            internet_status,
            home_security_status,
            memo 
        = VALUES(
            '$firstName',
            '$lastName',
            '$firstNameKana',
            '$lastNameKana',
            '$genre',
            " . ($birthDate == NULL ? "NULL" : "'$birthDate'") . ",
            '$email',
            '$tel1',
            '$tel2',
            '$carrier',
            '$contactable',
            '$contactableDate1',
            '$contactableTimeFrom1',
            '$contactableTimeTo1',
            '$contactableDate2',
            '$contactableTimeFrom2',
            '$contactableTimeTo2',
            '$actualPostalCode',
            '$actualAddress1',
            '$actualAddress2',
            '$actualAddress3',
            '$movingPostalCode',
            '$movingAddress1',
            '$movingAddress2',
            '$movingAddress3',
            " . ($movingDate==NULL ? "NULL" : "'$movingDate'") . ",
            '$electrical',
            '$cityGas',
            '$propaneGas',
            '$water',
            '$internet',
            '$oaEquipment',
            '$hpSecurity',
            '$waterServer',
            '$electricalStatus',
            '$gasStatus',
            '$internetStatus',
            '$homeSecurityStatus',
            '$memo'
            )

        "
    ;


    mysqli_query($conn, $sql);

    echo $sql;
    if (mysqli_query($conn, $sql) == 1) {
        echo "success";
    } else {
        echo "failed";
    }

    mysqli_close($conn);
}