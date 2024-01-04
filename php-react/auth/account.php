<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);
// Initialize the session
// セッション開始

$data = json_decode(file_get_contents("php://input"), true);

// Check if the user is already logged in, if yes then redirect him to welcome page
// ログインされた状態かチェック、された場合ページリダイレクト

// Include config file
require_once "../config/database.php";

// Define variables and initialize with empty values
// 変数を定義、初期値設定
$login_id = $password = "";

if ( isset( $data['loginId'] ) ) {
    $login_id = $data['loginId'];
}
if ( isset($data['password']) ) {
    $password = $data['password'];
}

// Processing form data when form is submitted
// 送信データ実行処理
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate credentials
    // 入力された値のバリデーション
    if( isset($login_id) && isset($password) ) {

        // Prepare a select statement
        // db値取得準備
        $sql = "SELECT `login_id`, `password` FROM accounts WHERE `login_id` = ?";
        // echo $sql;

        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            // 準備中の取得値にパラメーターとして変数をバインド
            mysqli_stmt_bind_param($stmt, "s", $param_login_id);
            // Set parameters
            // パラメーター設定
            $param_login_id = $login_id;
            // Attempt to execute the prepared statement
            // 準備中の取得値の実行開始
            if(mysqli_stmt_execute($stmt)){
                // Store result
                // 戻り値を保存
                mysqli_stmt_store_result($stmt);
                // Check if username exists, if yes then verify password
                // ユーザーが存在かチェック、存在の場合パスワード値をチェック
                if(mysqli_stmt_num_rows($stmt) == 1){
                    // Bind result variables
                    // 戻り値変数をバインド
                    mysqli_stmt_bind_result($stmt, $login_id, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){

                            // Password is correct, so start a new session
                            // パスワード正の場合、セッション開始
                            session_start();
                            // Store data in session variables
                            // データをセッション変数として保存
                            $_SESSION["loggedin"] = true;
                            // $_SESSION["id"] = $id;
                            $_SESSION["login_id"] = $login_id;

                            // Redirect user to welcome page
                            // リダイレクト
                            echo 'sucess';

                        } else {
                            /**
                             * Limit failed login_id attempts
                             */
                            // IPアドレス取得
                            $ip = $_SERVER['REMOTE_ADDR'];
                            // Storing time in variable
                            $t=time();
                            // 10 minutes 15*60 = 900;
                            $diff = (time()-900);

                            mysqli_query($conn, "INSERT INTO login VALUES (null,'$ip','$t')"); //Insert Query
                            $result = mysqli_query($conn, "SELECT COUNT(*) FROM login WHERE ip_address LIKE '$ip' 
                                    AND time_diff > $diff"); //Fetching Data 
                            $attempt_count = mysqli_fetch_array($result);

                            if($attempt_count[0] > 3) {
                                echo "blocked";
                            }

                            // Display an error message if password is not valid
                            // パスワードが一致しない場合、エラーメッセージを表示
                            echo "failed";
                        }
                    }
                } else {
                    /**
                     * Limit failed login attempts
                     */
                    // IPアドレス取得
                    $ip = $_SERVER['REMOTE_ADDR'];
                    // Storing time in variable
                    $t=time();
                    // 10 minutes 15*60 = 900;
                    $diff = (time()-900);

                    mysqli_query($conn, "INSERT INTO login VALUES (null,'$ip','$t')"); //Insert Query
                    $result = mysqli_query($conn, "SELECT COUNT(*) FROM login WHERE ip_address LIKE '$ip' 
                            AND time_diff > $diff"); //Fetching Data 
                    $attempt_count = mysqli_fetch_array($result);

                    if($attempt_count[0] > 3) {
                        echo "blocked";
                    } else {
                        // Display an error message if login ID doesn't exist
                        // ログインIDが一致しない場合、エラーメッセージを表示
                        echo "failed";
                    }

                }
            } else{
                echo "エラーが発生しました。申し訳ございませんが、お時間をかけて再度ログインください。";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    } else {

    }

    // Close connection
    mysqli_close($conn);
}
