<?php
    class Mtgroom extends Controller {
        public function __construct() {
            $this->roomModel = $this->model('Room');
        }

        public function index($slug = null) {
            if (!isLoggedIn()){
                redirect('index');
            }
            if($slug == null) {
                $rooms = $this->roomModel->getRooms();
                $data = [
                    'rooms' => $rooms
                ];
                $this->view('mtgroom/index', $data);
            } else {
                $room = $this->roomModel->getRoomBySlug($slug);
                $mtgrooms = $this->roomModel->getRooms();
                $data = [
                    'room' => $room,
                    'mtgrooms' => $mtgrooms,
                    'page' => 'show'
                ];
                $this->view('mtgroom/show', $data);
            }
        }

        public function create() {
            if (!isLoggedIn()){
                redirect('index');
            }
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Process form
                $data = [
                    'slug' => trim($_POST['slug']),
                    'html' => trim($_POST['html']),
                    'slug_err' => '',
                    'html_err' => '',
                ];

                // Validate slug
                if(empty($data['slug'])) {
                    $data['slug_err'] = 'ミーティング版を入力ください';
                }

                // Validate Html
                if(empty($data['html'])) {
                    $data['html_err'] = 'Html内容を入力ください';
                }

                // Check if no errors
                if(empty($data['slug_err']) && empty($data['html_err'])) {
                    // Validated
                    // die('Success');
                    $this->roomModel->addRoom($data);
                } else {
                    // Load view with errors
                    $this->view('mtgroom/create', $data);
                }

            } else {
                // Init data
                $data = [
                    'slug' => '',
                    'html' => '',
                    'slug_err' => '',
                    'html_err' => '',
                ];

                // Load view
                $this->view('mtgroom/create', $data);
            }
        }

        public function edit($slug){
            if (!isLoggedIn()){
                redirect('index');
            }

            $room = $this->roomModel->getRoomBySlug($slug);

            $data = [
                'room' => $room
            ];

            $this->view('mtgroom/edit', $data);
        }

        public function confirm(){
            if (!isLoggedIn()){
                redirect('index');
            }
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                $slug = $_POST['slug'];
                $html = $_POST['html'];

                $_SESSION['slug'] = $slug;
                $_SESSION['html'] = $html;

                $mtgrooms = $this->roomModel->getRooms();

                $data = [
                    'slug' => $slug,
                    'html' => $html,
                    'mtgrooms' => $mtgrooms,
                    'confirm' => true,
                    'page' => 'confirm'
                ];

                if(isset($_POST['id'])){
                    $id = $_POST['id'];
                    $_SESSION['id'] = $id;
                    $data['id'] = $id;
                }

                $this->view('mtgroom/confirm', $data);
            } else {
                redirect('mtgroom');
            }
        }

        public function complete(){
            if (!isLoggedIn()){
                redirect('index');
            }
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $data = [];
                $slug = $_SESSION['slug'];
                $html = $_SESSION['html'];

                if(isset($_SESSION['id'])){
                    $id = $_SESSION['id'];

                    if(isset($id) && isset($slug) && isset($html)){
                        $data['id'] = $id;
                        $data['slug'] = $slug;
                        $data['html'] = $html;
    
                        $update = $this->roomModel->updateRoom($data);

                        $res = [];
                        if($update){
                            $res['code'] = 200;
                        } else {
                            $res['code'] = 500;
                        }
                        $this->view('mtgroom/complete', $res);

                    }
 
                } else if(isset($slug) && isset($html)){
                    $data['slug'] = $slug;
                    $data['html'] = $html;
    
                    $add = $this->roomModel->addRoom($data);

                    $res = [];
                    if($add){
                        $res['code'] = 200;
                    } else {
                        $res['code'] = 500;
                    }
                    $this->view('mtgroom/complete', $res);

                }  else {
                    redirect('mtgroom');
                }
                
            } else {
                redirect('mtgroom');
            }
        }

    }