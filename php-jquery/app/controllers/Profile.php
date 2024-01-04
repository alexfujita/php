<?php
    class Profile extends Controller {
        public function __construct() {
        }

        public function index(){
            $this->view('profile');
        }
    
    }