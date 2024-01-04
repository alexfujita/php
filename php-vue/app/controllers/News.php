<?php
    class News extends Controller {
        public function __construct() {
            $this->newsModel = $this->model('Info');
        }

        public function index($slug = null) {
          if (!isLoggedIn()){
            redirect('index');
          }
          if($slug == null) {
          $this->view('news/index');
        }
      }

      public function create() {
        if (!isLoggedIn()){
          redirect('index');
        }
        if(isset($_SESSION['item']) && empty($_SESSION['id'])) {
          $data = [
            'published' => $_SESSION['published'],
            'item' => $_SESSION['item'],
            'link' => $_SESSION['link'],
            'target' => $_SESSION['target'],
            'status' => $_SESSION['status']
          ];
        } elseif(isset($_SESSION['id'])){
          unset($_SESSION['id']);
          unset($_SESSION['published']);
          unset($_SESSION['item']);
          unset($_SESSION['link']);
          unset($_SESSION['target']);
          unset($_SESSION['status']);
          $data = [];
        } else {
          $data = [];
        }
        // Load view
        $this->view('news/create' , $data);
      }

        public function edit($id){
          if (!isLoggedIn()){
            redirect('index');
          }
          if(isset($_SESSION['item'])) {
            $data = [
              'id' => $_SESSION['id'],
              'published' => $_SESSION['published'],
              'item' => $_SESSION['item'],
              'link' => $_SESSION['link'],
              'target' => $_SESSION['target'],
              'status' => $_SESSION['status']
            ];
          } else {
            $news = $this->newsModel->getNewsItem($id);
            $data = [
              'news'=>$news
            ];
          }
          // Load view
          $this->view('news/edit', $data);
        }

        public function confirm(){
          if (!isLoggedIn()){
            redirect('index');
          }
          if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_SESSION['published'] = $_POST['datepicker'];
            $_SESSION['item'] = $_POST['item'];
            $_SESSION['link'] = isset($_POST['link']) ? $_POST['link'] : null;
            $_SESSION['target'] = isset($_POST['target']) ? $_POST['target'] : null;


            if(isset($_POST['status'])){
              $_SESSION['status'] = true;
            } else {
              $_SESSION['status'] = false;
            }
            if(isset($_POST['id'])){
              $_SESSION['id'] = $_POST['id'];
              $data = [
                'id' => $_SESSION['id'],
                'published' => $_SESSION['published'],
                'item' => $_SESSION['item'],
                'link' => $_SESSION['link'],
                'target' => $_SESSION['target'],
                'status' => $_SESSION['status']
              ];
            } else {
              $data = [
                'published' => $_SESSION['published'],
                'item' => $_SESSION['item'],
                'link' => $_SESSION['link'],
                'target' => $_SESSION['target'],
                'status' => $_SESSION['status']
              ];
            }
            // Load view
            $this->view('news/confirm', $data);
          } else {
            // Load view
            $this->view('news/confirm');
          }
        }

        public function complete(){
          if (!isLoggedIn()){
            redirect('index');
          }
          if(isset($_SESSION['id'])){
            unset($_SESSION['id']);
          }
          if(isset($_SESSION['published'])){
            unset($_SESSION['published']);
          }
          if(isset($_SESSION['item'])){
            unset($_SESSION['item']);
          }
          if(isset($_SESSION['link']) || empty($_SESSION['link'])){
            unset($_SESSION['link']);
          }
          if(isset($_SESSION['target']) || empty($_SESSION['target'])){
            unset($_SESSION['target']);
          }
          if(isset($_SESSION['status'])){
            unset($_SESSION['status']);
          }
            // Load view
            $this->view('news/complete');
        }

    }

