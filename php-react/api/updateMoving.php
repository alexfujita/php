<?php
$data = json_decode(file_get_contents("php://input"), true);

// Include config file
require_once "../config/database.php";

// Define variables and initialize with empty values
// 変数を定義、初期値設定
$id = 0;
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
$actualAddress4 = "";
$actualInfra = 0;
$movingDate = "";
$movingPostalCode = "";
$movingAddress1 = "";
$movingAddress2 = "";
$movingAddress3 = "";
$movingAddress4 = "";
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
 "id",
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
 "actualAddress4",
 "actualInfra",
 "movingDate",
 "movingPostalCode",
 "movingAddress1",
 "movingAddress2",
 "movingAddress3",
 "movingAddress4",
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
    $sql_insert =  
        "INSERT INTO moving_info (
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
            actual_address_4,
            moving_postal_code,
            moving_address_1,
            moving_address_2,
            moving_address_3,
            moving_address_4,
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
            " . ($contactableDate1 == NULL ? "NULL" : "'$contactableDate1'") . ",
            " . ($contactableTimeFrom1 == NULL ? "NULL" : "'$contactableTimeFrom1'") . ",
            " . ($contactableTimeTo1 == NULL ? "NULL" : "'$contactableTimeTo1'") . ",
            " . ($contactableDate2 == NULL ? "NULL" : "'$contactableDate2'") . ",
            " . ($contactableTimeFrom2 == NULL ? "NULL" : "'$contactableTimeFrom2'") . ",
            " . ($contactableTimeTo2 == NULL ? "NULL" : "'$contactableTimeTo2'") . ",
            '$actualPostalCode',
            '$actualAddress1',
            '$actualAddress2',
            '$actualAddress3',
            '$actualAddress4',
            '$movingPostalCode',
            '$movingAddress1',
            '$movingAddress2',
            '$movingAddress3',
            '$movingAddress4',
            " . ($movingDate　==　NULL ? "NULL" : "'$movingDate'") . ",
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
        )"
    ;

    $sql_update = "
        UPDATE moving_info SET 
        first_name = '$firstName',
        last_name = '$lastName',
        first_name_kana = '$firstNameKana',
        last_name_kana = '$lastNameKana',
        genre = '$genre',
        birthday = " . ($birthDate == NULL ? "NULL" : "'$birthDate'") . ",
        email = '$email',
        tel_1 = '$tel1',
        tel_2 = '$tel2',
        carrier = '$carrier',
        contactable = '$contactable',
        contactable_date_1 = " . ($contactableDate1 == NULL ? "NULL" : "'$contactableDate1'") . ",
        contactable_time_from_1 = " . ($contactableTimeFrom1 == NULL ? "NULL" : "'$contactableTimeFrom1:00:00'") . ",
        contactable_time_to_1 = " . ($contactableTimeTo1 == NULL ? "NULL" : "'$contactableTimeTo1:00:00'") . ",
        contactable_date_2 = " . ($contactableDate2 == NULL ? "NULL" : "'$contactableDate2'") . ",
        contactable_time_from_2 = " . ($contactableTimeFrom2 == NULL ? "NULL" : "'$contactableTimeFrom2:00:00'") . ",
        contactable_time_to_2 = " . ($contactableTimeTo2 == NULL ? "NULL" : "'$contactableTimeTo2:00:00'") . ",
        actual_postal_code = '$actualPostalCode',
        actual_address_1 = '$actualAddress1',
        actual_address_2 = '$actualAddress2',
        actual_address_3 = '$actualAddress3',
        actual_address_4 = '$actualAddress4',
        moving_postal_code = '$movingPostalCode',
        moving_address_1 = '$movingAddress1',
        moving_address_2 = '$movingAddress2',
        moving_address_3 = '$movingAddress3',
        moving_address_4 = '$movingAddress4',
        moving_date = " . ($movingDate == NULL ? "NULL" : "'$movingDate'") . ",
        electrical = '$electrical',
        city_gas = '$cityGas',
        propane_gas = '$propaneGas',
        water = '$water',
        internet = '$internet',
        oa_equipment = '$oaEquipment',
        hp_security = '$hpSecurity',
        water_server = '$waterServer',
        electrical_status = '$electricalStatus',
        gas_status = '$gasStatus',
        internet_status = '$internetStatus',
        home_security_status = '$homeSecurityStatus',
        memo = '$memo'
        WHERE id = '$id'
    ";

    is_null($id) ? $id = 0 : $id = $id;
    $sql = "SELECT * FROM moving_info WHERE id = $id";
    
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