<?php
    class Enquete {
        private $db;

        public function __construct() {
            $this->db = new Database('mypage');
        }

        public function findEnquetes() {
            $query = "SELECT count(uid) as enquetes, uid FROM enquetes GROUP BY uid;";
            $this->db->query($query);

            return $this->db->resultSet();
        }

    }