<?php
    class Contact extends Controller {
        public function __construct() {
        }

        public function index(){
            $data = [
                'page' => 'contact'
            ];
            $this->view('contact', $data);
        }
    
    }