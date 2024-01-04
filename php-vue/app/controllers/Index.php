<?php
    class Index extends Controller {
        public function __construct() {
            $this->loginModel = $this->model('Login');
        }

        public function index(){
            if(isLoggedIn()){
                redirect('mtgroom');
            }

            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // Process form
                // Sanitize POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                
                // Init data
                $data =[
                    'name' => isset($_POST['name']) ? trim($_POST['name']) : '',
                    'password' => isset($_POST['password']) ? trim($_POST['password']) : '',
                    'name_err' => '',
                    'password_err' => '',      
                ];
    
                // ユーザネームバリデーション
                if(empty($data['name'])){
                    $data['name_err'] = 'ユーザ名を入力ください';
                }
    
                // パスワード　バリデーション
                if(empty($data['password'])){
                    $data['password_err'] = 'パスワードを入力ください';
                }
    
                // Check for user/email
                if($this->loginModel->findLoginName($data['name'])){
                    
                } else {
                    $data['name_err'] = 'ユーザーが存在していません';
                }
    
                // エラーが空白か
                if(empty($data['name_err']) && empty($data['password_err'])){

                    // Check and set logged in user
                    $loggedInUser = $this->loginModel->authenticate($data['name'], $data['password']);
                    if($loggedInUser){
                        // Create Session
                        $this->createUserSession($loggedInUser);
                        redirect('bags');
                      } else {
                        $data['password_err'] = 'パスワードを確認ください';
            
                        $this->view('index', $data);
                      }
                } else {
                    // エラー出力
                    $this->view('index', $data);
                }
    
            } else {
              $data = [
                    'name' => '',
                    'password' => '',
                    'name_err' => '',
                    'password_err' => '',   
                ];
            }
            $this->view('index', $data);
        }

        public function login(){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // Process form
                // Sanitize POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                
                // Init data
                $data =[
                    'name' => isset($_POST['name']) ? trim($_POST['name']) : '',
                    'password' => isset($_POST['password']) ? trim($_POST['password']) : '',
                    'name_err' => '',
                    'password_err' => '',      
                ];
    
                // ユーザネームバリデーション
                if(empty($data['name'])){
                    $data['name_err'] = 'ユーザ名を入力ください';
                }
    
                // パスワード　バリデーション
                if(empty($data['password'])){
                    $data['password_err'] = 'パスワードを入力ください';
                }
    
                // Check for user/email
                if($this->loginModel->findLoginName($data['name'])){
                    
                } else {
                    $data['name_err'] = 'ユーザーが存在していません';
                }
    
                // エラーが空白か
                if(empty($data['name_err']) && empty($data['password_err'])){

                    // Check and set logged in user
                    $loggedInUser = $this->loginModel->authenticate($data['name'], $data['password']);
                    if($loggedInUser){
                        // Create Session
                        $this->createUserSession($loggedInUser);
                        redirect('bags');
                      } else {
                        $data['password_err'] = 'パスワードを確認ください';
            
                        $this->view('index', $data);
                      }
                } else {
                    // エラー出力
                    $this->view('index', $data);
                }
    
            } else {
              $data = [
                    'name' => '',
                    'password' => '',
                    'name_err' => '',
                    'password_err' => '',   
                ];
            }
            $this->view('login/index', $data);
        }
    
        public function createUserSession($login){
            $_SESSION['login_id'] = $login->id;
            $_SESSION['login_name'] = $login->name;
            redirect('index');
        }
    
        public function logout(){
            unset($_SESSION['login_id']);
            unset($_SESSION['login_name']);
            session_destroy();
            redirect('index');
        }
    
    }