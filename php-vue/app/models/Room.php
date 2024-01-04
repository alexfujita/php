<?php
    class Room {
        private $db;

        public function __construct() {
            $this->db = new Database('mypage');;
        }

        public function getAllRooms(){
            // 全ての流ルームを取得
            $query = "SELECT * FROM mtgroom ORDER BY id DESC;";
            $this->db->query($query);

            return $this->db->resultSet();
        }

        public function getRooms(){
            // 最新ミーティングルーム以外のレコードを取得
            $query = "SELECT * FROM mtgroom WHERE id != (SELECT MAX(id) FROM mtgroom) ORDER BY slug DESC;";
            $this->db->query($query);

            return $this->db->resultSet();
        }

        public function getRoom($id){
            $query = "SELECT * FROM mtgroom WHERE id = :id";
            $this->db->query($query);
            $this->db->bind(':id', $id);

            $row = $this->db->single();
            return $row;
        }

        public function getIndexRoom() {
            $query = "SELECT html FROM mtgroom ORDER BY id DESC LIMIT 1;";
            $this->db->query($query);

            return $this->db->resultSet();
        }

        public function addRoom($data){
            $query = "INSERT INTO mtgroom (slug, html) VALUES (:slug, :html);";
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

        public function getRoomBySlug($slug){
            $query = "SELECT * FROM mtgroom WHERE slug = :slug";
            $this->db->query($query);
            $this->db->bind(':slug', $slug);
            $row = $this->db->single();
            return $row;
        }

        public function updateRoom($data){
            $query = "UPDATE mtgroom SET slug = :slug, html = :html WHERE id = :id;";
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
            $query = "UPDATE mtgroom SET status = :status WHERE id = :id;";
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

        public function deleteRoom($id){
            $query = "DELETE FROM mtgroom WHERE id = :id LIMIT 1;";
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