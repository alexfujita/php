<?php
    class Bag {
        private $db;

        public function __construct() {
            $this->db = new Database('mypage');
        }

        public function getBags(){
            $query = "SELECT * FROM bags ORDER BY sort ASC;";
            $this->db->query($query);

            return $this->db->resultSet();
        }

        public function getBag($id){
            $query = "SELECT * FROM bags WHERE id = :id";
            $this->db->query($query);
            $this->db->bind(':id', $id);

            $row = $this->db->single();
            return $row;
        }

        public function countBags(){
            $query = "SELECT count(id) as count FROM bags;";
            $this->db->query($query);

            $row = $this->db->single();
            return $row;
        }

        public function addBag($data){
            $query = "INSERT INTO bags (img, status, special, start, end, sort) VALUES (:img, :status, :special, :start, :end, :sort);";
            $this->db->query($query);

            // bind
            $this->db->bind(':img', $data['img']);
            $this->db->bind(':status', $data['status']);
            $this->db->bind(':special', $data['special']);
            $this->db->bind(':start', $data['start']);
            $this->db->bind(':end', $data['end']);
            $this->db->bind(':sort', $data['sort']);

            // 実行
            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
        }

        public function updateBag($data){
            $query = "UPDATE bags SET img = :img, status = :status, special = :special, start = :start, end = :end WHERE id = :id;";
            $this->db->query($query);

            // bind
            $this->db->bind(':id', $data['id']);
            $this->db->bind(':img', $data['img']);
            $this->db->bind(':status', $data['status']);
            $this->db->bind(':special', $data['special']);
            $this->db->bind(':start', $data['start']);
            $this->db->bind(':end', $data['end']);

            // 実行
            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
        }

        public function updateSpecial($data){
            $query = "";
            if($data['special'] == '0'){
                $query = "UPDATE bags SET special = :special, start = null, end = null WHERE id = :id;";
            } else {
                $query = "UPDATE bags SET special = :special WHERE id = :id;";
            }
            $this->db->query($query);

            $this->db->bind(':id', $data['id']);
            $this->db->bind(':special', $data['special']);

            // 実行
            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
        }

        public function updateStatus($data){
            $query = "UPDATE bags SET status = :status WHERE id = :id;";
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

        public function updateSort($bags){
            $value_strings = [];
            foreach($bags as $bag){
                $value_strings[] = '(' . $bag['id'] . ', ' . $bag['sort'] . ')';
            }
            $value_string = implode($value_strings, ', ');
            $query = "INSERT INTO bags (id, sort) VALUES $value_string ON DUPLICATE KEY UPDATE sort = VALUES(sort);";
            $this->db->query($query);

            // 実行
            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
        }

        public function deleteBag($id){
            $query = "DELETE FROM bags WHERE id = :id LIMIT 1;";
            $this->db->query($query);

            $this->db->bind(':id', $id);

            // 実行
            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
        }

        public function afterDeleteSort($ids, $length){
            $value_strings = [];
            $count = 0;
            foreach($ids as $id){
                if(intval($length) >= $count){
                    $count++;
                    $value_strings[] = "(" . $id . ", '" . $count . "')";
                }
            }
            $value_string = implode( ', ', $value_strings);
            $query = "INSERT INTO bags (id, sort) VALUES $value_string ON DUPLICATE KEY UPDATE sort = VALUES(sort);";
            $this->db->query($query);

            // 実行
            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
        }
    }