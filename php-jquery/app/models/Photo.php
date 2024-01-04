<?php
    class Photo {
        private $db;

        public function __construct(){
            $this->db = new Database();
        }

        public function getPhotos() {
            $query = "
                SELECT
                    filename, is_feature, w.property_ja
                FROM
                    photos p
                INNER JOIN
                    works w
                ON
                    work_id = w.id
                ORDER BY
                    w.id
                DESC
            ;";
        }
    }