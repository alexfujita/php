<?php



// Include config file
require_once "../config/database.php";
 
// Define variables and initialize with empty values
$account = $password = $confirm_password = "";
$account_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate account
    if(empty(trim($_POST["account"]))){
        $account_err = "Please enter a account.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM accounts WHERE account = ?";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_account);
            
            // Set parameters
            $param_account = trim($_POST["account"]);


            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){

                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $account_err = "This account is already taken.";
                } else{
                    $account = trim($_POST["account"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($account_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO accounts (account, password) VALUES (?, ?)";

        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_account, $param_password);
            
            // Set parameters
            $param_account = $account;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            var_dump($_POST["account"]);
            var_dump($_POST["password"]);
            var_dump($_POST["confirm_password"]);

            var_dump(mysqli_stmt_execute($stmt));

            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{
                ini_set("display_errors", 1);
                error_reporting(E_ALL);
                echo "Something went wrong. Please try again later...";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($conn);
}
?>
 
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up</title>
    <link rel="stylesheet" href="../assets/styles/style.css">
    <link rel="stylesheet" href="../assets/styles/login.css">
    <link rel="stylesheet" type="text/css" href="../assets/styles/semantic.min.css">
</head>
<body>
    <div class="main">
        <div class="container__login">
            <div class="login">
                <div class="logo">
                    <img src="../assets/img/logo.jpg" alt="">
                </div>
                <div class="login__form">
                    <h3>ユーザー登録</h3>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                        <div class="ui form error">
                            <div class="inline fields">
                                <div class="twelve wide field" style="width: 100% !important;" >
                                    <label>アカウントID</label>
                                    <input type="text" name="account" value="<?php echo $account; ?>">
                                </div>
                            </div>
                            <div class="ui error message" style="width: 100%; text-align: center; padding: 6px; font-size: 11px; margin: 1em 0 2em;"><?php echo $account_err; ?></div>
                            <div class="inline fields">
                                <div class="twelve wide field" style="width: 100% !important;">
                                    <label>パスワード</label>
                                    <input type="password" name="password" value="<?php echo $password; ?>">
                                </div>
                            </div>
                            <div class="ui error message" style="width: 100%; text-align: center; padding: 6px; font-size: 11px; margin: 1em 0 2em;"><?php echo $password_err; ?></div>
                            <div class="inline fields">
                                <div class="twelve wide field" style="width: 100% !important;">
                                    <label>パスワード（確認）</label>
                                    <input type="password" name="confirm_password" value="<?php echo $confirm_password; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="ui form" style="display: flex; justify-content: flex-end; margin-top: 30px;">
                            <input type="submit" class="ui primary button" style="display: flex; align-items: center; justify-content: center; flex-basis: 25%; padding: 0; margin-right: 10px;" value="送信">
                            <input type="reset" class="ui button" style="display: flex; align-items: center; justify-content: center; flex-basis: 25%; padding: 0; margin-left: 10px;" value="リセット">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>    
</body>
</html>