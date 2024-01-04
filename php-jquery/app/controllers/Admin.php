<?php

    class Admin extends Controller {
        public function __construct()
        {
            $this->workModel = $this->model('Work');
            $this->photoModel = $this->model('Photo');
            $this->newsModel = $this->model('News');
        }

        public function index() {}

        public function works()
        {
            $data = $this->workModel->getWorks();
            $this->view('admin/works', $data);
        }

        public function work($id)
        {
            $works = $this->workModel->getWork($id);
            if ($works) {
                $categories = $this->workModel->getCategories($works->category_id);
                $locations = $this->workModel->getLocations($works->location_id);
                $photos = $this->workModel->getPhotos($id);
                $data = [
                    'works' => $works,
                    'categories' => $categories,
                    'locations' => $locations,
                    'photos' => $photos
                ];
            } else {
                $data = [];
            }

            $this->view('admin/work', $data);
        }

        public function photos()
        {
            $data = $this->photoModel->getPhotos();
            var_dump($data);
            $this->view('admin/photos', $data);
        }

        public function photo() {
            $this->view('admin/photos/create');
        }

        public function news($id = null){
            if (!$id) {
                $data = $this->newsModel->getNews();
                $this->view('admin/news/index', $data);
            } else if ($id === 'add') {
                $this->view('admin/news/create');
            } else {
                $data = $this->newsModel->getSingleNews($id);
                $this->view('admin/news/edit', $data);
            }

        }

    }