<?php
    class Event {
        private $db;

        public function __construct() {
            $this->db = new Database('mypage');
        }

        public function findEvents() {
            $query = "SELECT count(uid) as events, uid FROM events GROUP BY uid;";
            $this->db->query($query);

            return $this->db->resultSet();
        }

    }