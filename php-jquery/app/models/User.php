<?php
  class User {
    private $db;

    public function __construct(){
        $this->db = new Database('mypage');
    }

    public function findUser($name){
        $this->db->query('SELECT * FROM users WHERE name = :name');
        // Bind value
        $this->db->bind(':name', $name);
  
        $row = $this->db->single();
  
        // Check row
        if($this->db->rowCount() > 0){
          return true;
        } else {
          return false;
        }
    }

    public function authenticate($name, $password){
      $this->db->query('SELECT * FROM users WHERE name = :name');
      $this->db->bind(':name', $name);

      $row = $this->db->single();

      $hashed_password = $row->password;
      if(password_verify($password, $hashed_password)){
        return $row;
      } else {
        return false;
      }
    }

}