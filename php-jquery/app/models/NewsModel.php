<?php
    class NewsModel {
        private $db;

        public function __construct(){
            $this->db = new Database();
        }

        public function getNews() {
            $query = "
                SELECT
                    n.id, work_id, date, title, body, IFNULL(image, w.photo) as image, link
                FROM
                    news n
                LEFT JOIN
                    works w
                ON
                    n.work_id = w.id
                ORDER BY
                    n.sort
                DESC
            ;";

            $this->db->query($query);

            return $this->db->resultSet();
        }

        public function getSingleNews($id) {
            $query = "
                SELECT
                    *
                FROM
                    news
                WHERE
                    id = :id
            ;";

            $this->db->query($query);
            $this->db->bind(':id', $id);
            return $this->db->single();
        }
    }