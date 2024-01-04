<?php
    class Index extends Controller {
        public function __construct() {
            $this->loginModel = $this->model('User');
        }

        public function index(){
            $data = [
                'page' => 'top'
            ];

            $this->view('index', $data);
        }
    
    }