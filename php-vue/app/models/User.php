<?php
  class User {
      private $db;

      public function __construct(){
          $this->db = new Database('login');
      }

      public function findUser($data){
        $ap_uid = $data['ap_uid'];
  
        $query = "SELECT id, mypage_nickname, tw_display_name, tw_photo_url, ig_display_name, ig_photo_url FROM users WHERE id = :ap_uid;";
        $this->db->query($query);
  
        // 値をバインド
        $this->db->bind(':ap_uid', $ap_uid);
  
        $row = $this->db->single();
        return $row;
      }
    }