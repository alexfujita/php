<?php
    class Work extends Controller {
        public function __construct() {
            $this->workModel = $this->model('WorkModel');
        }

        public function index($id = null){

            $work = $this->workModel->getWork($id);
            $photos = $this->workModel->getPhotos($id);
            $data = [
                'work' => $work,
                'photos' => $photos,
                'overflow' => 'hidden',
                'page' => 'work'
            ];
            $this->view('work', $data);
        }
    
    }