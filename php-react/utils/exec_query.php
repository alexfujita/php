<?php

function exec_query($host, $user, $pw, $db, $query) {
    if( !$res_dbcon = mysql_connect( $host, $user, $pw) ){
        return [
            'code' => '1',
            'message' => 'Database connection error.'
        ];
        exit;
    }

    mysql_set_charset("UTF8");
    mysql_select_db($db, $res_dbcon);

    $result = mysqli_query($query);

    if (!$result) {
        return [
            'code' => '1',
            'message' => 'Database error: ' . mysql_error()
        ];
        exit;
    }

    // insert/updateクエリなどselectじゃないクエリはbooleanが返ってきていて、かつ返却するデータなどもないのでそのまま返却
    if ($result === true) {
        return [
            'code' => '200'
        ];
    }

    $records = [];
    while ($record = mysql_fetch_assoc($result)) {
        array_push($records, $record);
    }

    mysql_close( $res_dbcon );

    return $records;
}
