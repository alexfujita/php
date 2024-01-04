<?php
    class Photos extends Controller {
        public function __construct() {
        }

        public function index() {}

        public function create() {
            $this->view('admin/photos/create');
        }

    }