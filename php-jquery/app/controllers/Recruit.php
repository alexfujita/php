<?php
    class Recruit extends Controller {
        public function __construct() {
        }

        public function index(){
            $data = [
                'page' => 'recruit'
            ];
            $this->view('recruit', $data);
        }
    
    }