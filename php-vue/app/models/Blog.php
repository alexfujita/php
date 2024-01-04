<?php
    class Blog {
        private $db;

        public function __construct() {
            $this->db = new Database('mypage');;
        }

        public function getAllBlogs(){
            // 全ての流ルームを取得
            $query = "SELECT * FROM blog ORDER BY id DESC;";
            $this->db->query($query);

            return $this->db->resultSet();
        }

        public function getBlogs(){
            // 最新ミーティングルーム以外のレコードを取得
            $query = "SELECT * FROM blog WHERE id != (SELECT MAX(id) FROM blog) ORDER BY slug DESC;";
            $this->db->query($query);

            return $this->db->resultSet();
        }

        public function getBlog($id){
            $query = "SELECT * FROM blog WHERE id = :id";
            $this->db->query($query);
            $this->db->bind(':id', $id);

            $row = $this->db->single();
            return $row;
        }

        public function getIndexBlog() {
            $query = "SELECT html FROM blog ORDER BY id DESC LIMIT 1;";
            $this->db->query($query);

            return $this->db->resultSet();
        }

        public function getCurrentBlog($slug = null){
            $query = '';
            if ($slug == null){
                $query = "SELECT * FROM blog ORDER BY id DESC LIMIT 1;";
            } else {
                $query = "SELECT * FROM blog WHERE slug = :slug;";
            }
            
            $this->db->query($query);
            $this->db->bind(':slug', $slug);

            return $this->db->single();
        }

        public function getNextBlog($id){
            $query = "SELECT * FROM blog WHERE id = (select min(id) from blog WHERE id > :id);";
            $this->db->query($query);
            $this->db->bind(':id', $id);

            return $this->db->single();
        }

        public function getPrevBlog($id){
            $query = "SELECT * FROM blog WHERE id = (select max(id) from blog WHERE id < :id);";
            $this->db->query($query);
            $this->db->bind(':id', $id);

            return $this->db->single();
        }

        public function addBlog($data){
            $query = "INSERT INTO blog (slug, html) VALUES (:slug, :html);";
            $this->db->query($query);

            // Bind values
            $this->db->bind(':slug', $data['slug']);
            $this->db->bind(':html', $data['html']);

            // Execute
            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
        }

        public function getBlogBySlug($slug){
            $query = "SELECT * FROM blog WHERE slug = :slug";
            $this->db->query($query);
            $this->db->bind(':slug', $slug);
            $row = $this->db->single();
            return $row;
        }

        public function updateBlog($data){
            $query = "UPDATE blog SET slug = :slug, html = :html WHERE id = :id;";
            $this->db->query($query);

            $this->db->bind(':id', $data['id']);
            $this->db->bind(':slug', $data['slug']);
            $this->db->bind(':html', $data['html']);

            // 実行
            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
        }

        public function updateStatus($data){
            $query = "UPDATE blog SET status = :status WHERE id = :id;";
            $this->db->query($query);

            $this->db->bind(':id', $data['id']);
            $this->db->bind(':status', $data['status']);

            // 実行
            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
        }

        public function deleteBlog($id){
            $query = "DELETE FROM blog WHERE id = :id LIMIT 1;";
            $this->db->query($query);

            $this->db->bind(':id', $id);

            // 実行
            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
        }
    }