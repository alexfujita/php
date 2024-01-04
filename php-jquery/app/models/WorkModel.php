<?php
    class WorkModel {
        private $db;

        public function __construct(){
            $this->db = new Database();
        }

        public function getWorks() {
            $query = "
                SELECT  
                    w.id, year, property_ja, property_en, category_ja, category_en, location_ja, location_en, photo
                FROM 
                    works w
                LEFT JOIN
                    categories c
                ON
                    category_id = c.id
                LEFT JOIN
                    locations l
                ON
                    location_id = l.id
                ORDER BY 
                    w.sort DESC;
            ";

            $this->db->query($query);

            return $this->db->resultSet();
        }

        public function getWork($id) {
            $query = "
            SELECT  
                w.id, year, property_ja, property_en, category_id, category_ja, category_en, location_id, location_ja, location_en, description, slug
            FROM 
                works w
            LEFT JOIN
                categories c
            ON
                category_id = c.id
                LEFT JOIN
                locations l
            ON
                location_id = l.id
            WHERE
                w.id = :id
            ;";

            $this->db->query($query);
            $this->db->bind(':id', $id);
            return $this->db->single();
        }

        public function getCategories($id)
        {
            $query = "
                SELECT
                    id, category_ja, category_en
                FROM
                    categories
                WHERE
                    id != :id
            ;";

            $this->db->query($query);
            $this->db->bind(':id', $id);
            return $this->db->resultSet();
        }

        public function getLocations($id)
        {
            $query = "
                SELECT
                    id, location_ja, location_en
                FROM
                    locations
                WHERE
                    id != :id
            ;";

            $this->db->query($query);
            $this->db->bind(':id', $id);
            return $this->db->resultSet();
        }

        public function getPhotos($work_id)
        {
            $query = "
                SELECT
                    work_id, filename, is_feature
                FROM
                    photos
                WHERE
                    work_id = :work_id
            ;";

            $this->db->query($query);
            $this->db->bind(':work_id', $work_id);
                return $this->db->resultSet();
        }

    }