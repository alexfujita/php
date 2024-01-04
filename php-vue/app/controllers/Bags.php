<?php
    class Bags extends Controller {
        public function __construct() {
            $this->bagModel = $this->model('Bag');
        }

        public function index($slug = null) {
            if (!isLoggedIn()){
                redirect('index');
            }
            if($slug == null) {
                $bags = $this->bagModel->getBags();
                $data = [
                    'bags' => $bags
                ];
                $this->view('bags/index', $data);
            } else {
                $bag = $this->blogModel->getBag($id);
                $bags = $this->blogModel->getBags();

                $data = [
                    'bag' => $bag,
                    'bags' => $bags,
                    'page' => 'show',
                ];
                $this->view('bag/show', $data);
            }
        }

        public function create() {
            if (!isLoggedIn()){
                redirect('index');
            }

            // Load view
            $this->view('bags/create', []);
        }

        public function edit($id){
            if (!isLoggedIn()){
                redirect('index');
            }
            $bag = $this->bagModel->getBag($id);
            $data = [
                'bag' => $bag
            ];

            // Load view
            $this->view('bags/edit', $data);
        }

        public function confirm($id){
            if (!isLoggedIn()){
                redirect('index');
            }
            $data = [];
            // Load view
            $this->view('bags/confirm', $data);
        }

        public function Complete(){
            if (!isLoggedIn()){
                redirect('index');
            }
            $data = [];
            // Load view
            $this->view('bags/Complete', $data);
        }

    }

