<?php
    class Blog extends Controller {
        public function __construct() {
            $this->blogModel = $this->model('Blog');
        }

        public function index($slug = null) {
            if (!isLoggedIn()){
                redirect('index');
            }
            if($slug == null) {
                $blogs = $this->blogModel->getBlogs();
                $data = [
                    'blogs' => $blogs
                ];
                $this->view('blog/index', $data);
            } else {
                $blog = $this->blogModel->getBlogBySlug($slug);
                $blogs = $this->blogModel->getBlogs();
                $blog_next = $this->blogModel->getNextBlog($blog->id);
                $blog_prev = $this->blogModel->getPrevBlog($blog->id);
                $class = [
                    'body' => 'home blog logged-in admin-bar blogpage customize-support'
                ];
                $data = [
                    'blog' => $blog,
                    'blogs' => $blogs,
                    'page' => 'show',
                    'class' => $class,
                    'blog_next' => $blog_next,
                    'blog_prev' => $blog_prev,
                ];
                $this->view('blog/show', $data);
            }
        }

        public function create() {
            if (!isLoggedIn()){
                redirect('index');
            }
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Process form
                $data = [
                    'slug' => trim($_POST['slug']),
                    'html' => trim($_POST['html']),
                    'slug_err' => '',
                    'html_err' => '',
                ];

                // Validate slug
                if(empty($data['slug'])) {
                    $data['slug_err'] = 'ミーティング版を入力ください';
                }

                // Validate Html
                if(empty($data['html'])) {
                    $data['html_err'] = 'Html内容を入力ください';
                }

                // Check if no errors
                if(empty($data['slug_err']) && empty($data['html_err'])) {
                    // Validated
                    $this->blogModel->addBlog($data);
                } else {
                    // Load view with errors
                    $this->view('blog/create', $data);
                }

            } else {
                /* 編集後に新規Createする場合SESSIONが残っているので
                    SESSIONをunsetする*/
                if(isset($_SESSION['id'])){
                    unset($_SESSION['id']);
                } elseif(isset($_SESSION['slug'])){
                    unset($_SESSION['slug']);
                } elseif(isset($_SESSION['html'])){
                    unset($_SESSION['html']);
                }
                // Init data
                $data = [
                    'slug' => '',
                    'html' => '',
                    'slug_err' => '',
                    'html_err' => '',
                ];

                // Load view
                $this->view('blog/create', $data);
            }
        }

        public function edit($slug){
            if (!isLoggedIn()){
                redirect('index');
            }

            $blog = $this->blogModel->getBlogBySlug($slug);

            $data = [
                'blog' => $blog
            ];

            $this->view('blog/edit', $data);
        }

        public function confirm(){
            if (!isLoggedIn()){
                redirect('index');
            }
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $slug = $_POST['slug'];
                $html = $_POST['html'];

                $_SESSION['slug'] = $slug;
                $_SESSION['html'] = $html;

                $mtgrooms = $this->blogModel->getBlogs();

                $class = [
                    'body' => 'home blog logged-in admin-bar blogpage customize-support'
                ];

                $data = [
                    'slug' => $slug,
                    'html' => $html,
                    'mtgrooms' => $mtgrooms,
                    'confirm' => true,
                    'page' => 'confirm',
                    'blog' => true,
                    'class' => $class
                ];

                if(isset($_POST['id'])){
                    $id = $_POST['id'];
                    $_SESSION['id'] = $id;
                    $data['id'] = $id;
                }

                $this->view('blog/confirm', $data);
            } else {
                redirect('blog');
            }
        }

        public function complete(){
            if (!isLoggedIn()){
                redirect('index');
            }
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $data = [];
                $slug = $_SESSION['slug'];
                $html = $_SESSION['html'] . "\r\n" . '</article>';

                if(isset($_SESSION['id'])){
                    $id = $_SESSION['id'];

                    if(isset($id) && isset($slug) && isset($html)){
                        $data['id'] = $id;
                        $data['slug'] = $slug;
                        $data['html'] = $html;

                        $update = $this->blogModel->updateBlog($data);

                        $res = [];
                        if($update){
                            $res['code'] = 200;
                        } else {
                            $res['code'] = 500;
                        }
                        $this->view('blog/complete', $res);
                    }

                } else if(isset($slug) && isset($html)){
                    $data['slug'] = $slug;
                    $data['html'] = $html;
                    $add = $this->blogModel->addBlog($data);

                    $res = [];
                    if($add){
                        $res['code'] = 200;
                    } else {
                        $res['code'] = 500;
                    }
                    $this->view('blog/complete', $res);

                } else {
                    redirect('blog');
                }
                
            } else {
                redirect('blog');
            }
        }



    }