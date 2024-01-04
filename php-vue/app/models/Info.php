<?php
    class info {
        private $db;

        public function __construct() {
            $this->db = new Database('mypage');
        }

        public function fetchNews(){
            $query = "SELECT published, item FROM news ORDER BY published DESC LIMIT 4;";
            $this->db->query($query);

            return $this->db->resultSet();
        }

        public function getNewsItems(){
            $query = "SELECT * FROM news ORDER BY created DESC;";
            $this->db->query($query);

            return $this->db->resultSet();
        }

        public function getNewsItem($id){
          $query = "SELECT * FROM news WHERE id = :id";
            $this->db->query($query);
            $this->db->bind(':id', $id);

            $row = $this->db->single();
            return $row;
      }

        public function updateStatus($data){
          $query = "UPDATE news SET status = :status WHERE id = :id;";
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

      public function deleteNewsItem($id){
        $query = "DELETE FROM news WHERE id = :id LIMIT 1;";
        $this->db->query($query);

        $this->db->bind(':id', $id);

        // 実行
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }
    public function addNews($data){
      $query = "INSERT INTO news (published, item, link, target, status) VALUES (:published, :item, :link, :target, :status);";
      $this->db->query($query);

      // bind
      $this->db->bind(':published', $data['published']);
      $this->db->bind(':item', $data['item']);
      $this->db->bind(':link', $data['link']);
      $this->db->bind(':target', $data['target']);
      $this->db->bind(':status', $data['status']);

      // 実行
      if($this->db->execute()){
          return true;
      } else {
          return false;
      }
    }
    public function updateNews($data){
      $query = "UPDATE news SET published = :published, item = :item, link = :link, target = :target, status = :status WHERE id = :id;";
      $this->db->query($query);

      // bind
      $this->db->bind(':id', $data['id']);
      $this->db->bind(':published', $data['published']);
      $this->db->bind(':item', $data['item']);
      $this->db->bind(':link', $data['link']);
      $this->db->bind(':target', $data['target']);
      $this->db->bind(':status', $data['status']);

      // 実行
      if($this->db->execute()){
          return true;
      } else {
          return false;
      }
    }

    }