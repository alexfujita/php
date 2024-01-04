<?php
    class News extends Controller {
        public function __construct() {
            $this->newsModel = $this->model('NewsModel');
        }

        public function index(){
            $data = $this->newsModel->getNews();
            $this->view('news', $data);
        }
    
    }