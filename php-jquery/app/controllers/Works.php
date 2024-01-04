<?php
    class Works extends Controller {
        public function __construct() {
            $this->workModel = $this->model('WorkModel');
        }

        public function index($slug = null){

            $data = $this->workModel->getWorks();

            $data = [
                'page' => 'works'
            ];

            $this->view('works', $data);
        }
    
    }