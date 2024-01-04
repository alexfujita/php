<?php
    class Invite {
        private $db;

        public function __construct() {
            $this->db = new Database('mypage');
        }

        public function addInvite($data){
            $query = "INSERT IGNORE INTO invites (invite_uid, invited_uid, invite_date) VALUES (:invite_uid, :invited_uid, :invite_date);";
            $this->db->query($query);

            // bind
            $this->db->bind(':invite_uid', $data['invite_uid']);
            $this->db->bind(':invited_uid', $data['invited_uid']);
            $this->db->bind(':invite_date', date('Y-m-d'));
            
            // 実行
            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
        }

    }