<?php
    class Member {
        private $db;

        public function __construct(){
            $this->db = new Database('mypage');
        }

        public function findMembers(){
            $query = "SELECT * FROM members ORDER BY created DESC;";
            $this->db->query($query);
            return $this->db->resultSet();
        }

        public function findUids(){
            $query = "SELECT uid FROM members;";
            $this->db->query($query);
            return $this->db->resultCol();
        }

        // メンバー取得
        public function findMember($uid){
            $query = "SELECT uid, nickname, chips, bags, level, img, members.created FROM members INNER JOIN bags ON members.bag_id = bags.id WHERE uid = :uid ORDER BY created DESC;";
            $this->db->query($query);

            $this->db->bind(':uid', $uid);

            return $this->db->single();
        }

        // 袋ID取得
        public function findBagId($uid){
            $query = "SELECT bag_id FROM members WHERE uid = :uid;";
            $this->db->query($query);

            $this->db->bind(':uid', $uid);

            return $this->db->single();
        }

        // メンバー追加
        public function addMember($uid){
            $query = "INSERT INTO members (uid) VALUES (:uid);";
            $this->db->query($query);
            $this->db->bind(':uid', $uid);

            // 実行
            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
        }

        // Nickname更新
        public function updateNickname($data){
            $query = "UPDATE members SET nickname = :nickname WHERE uid = :uid;";
            $this->db->query($query);
            $this->db->bind(':uid', $data['uid']);
            $this->db->bind(':nickname', $data['nickname']);

            // 実行
            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
        }

        // プロフィール画像更新
        public function updateBagId($data){
            $query = "UPDATE members SET bag_id = :bag_id WHERE uid = :uid;";
            $this->db->query($query);
            $this->db->bind(':uid', $data['uid']);
            $this->db->bind(':bag_id', $data['bag_id']);

            // 実行
            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
        }

        // チップス、袋、合計チップス、レベル値更新
        public function upsertChipsTotal($data){
            $value_strings = [];
            foreach($data as $d){
                $value_strings[] = '(' . $d['uid'] . ', ' . $d['chips'] . ', ' . $d['bags'] . ', ' . $d['chips_total'] . ', ' . $d['level'] . ')';
            }
            $value_string = implode($value_strings, ', ');

            $query = "INSERT INTO members (uid, chips, bags, chips_total, level) VALUES $value_string ON DUPLICATE KEY UPDATE chips = VALUES(chips), bags = VALUES(bags), chips_total = VALUES(chips_total), level = VALUES(level);";
            $this->db->query($query);

            // 実行
            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
        }

        // 投稿回数更新
        public function updateSnsPostCount($count){
            foreach($count as $c){
                $query = 'UPDATE members SET posts = ' . $c['count'] . ' WHERE uid = ' . $c['user_id'] . ';';
                $this->db->query($query);
                // $this->db->debugSql();
                // 実行
                $this->db->execute();

            }

        }

        // ミーティングルームアンケートタグからDB更新
        public function updateMtgroom($data){
            $value_strings = [];
            foreach($data as $d){
                $value_strings[] = '(' . $d['uid'] . ', ' . count($d['tags']['mtgroom']) . ')';
            }
            $value_string = implode($value_strings, ', ');

            $query = "INSERT INTO members (uid, mtgroom) VALUES $value_string ON DUPLICATE KEY UPDATE mtgroom = VALUES(mtgroom);";
            $this->db->query($query);

            // 実行
            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
        }

        // 商品アンケートタグからDB更新
        public function updateProduct($data){
            $value_strings = [];
            foreach($data as $d){
                $value_strings[] = '(' . $d['uid'] . ', ' . count($d['tags']['product']) . ')';
            }
            $value_string = implode($value_strings, ', ');

            $query = "INSERT INTO members (uid, product) VALUES $value_string ON DUPLICATE KEY UPDATE product = VALUES(product);";
            $this->db->query($query);

            // 実行
            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
        }

        // フォーム招待取得
        public function findInvites(){
            $query = "SELECT invite_uid AS uid, count(invite_uid) AS count FROM invites GROUP BY invite_uid;";
            $this->db->query($query);
            return $this->db->resultSet();
        }

        // フォーム招待更新
        public function updateInvites($invites){
            $value_strings = [];
            foreach ($invites as $invite) {
                $value_strings[] = '(' . $invite->uid . ', ' . $invite->count . ')';
            }
            $value_string = implode($value_strings, ', ');

            $query = 'INSERT INTO members (uid, invites) VALUES ' . $value_string . ' ON DUPLICATE KEY UPDATE invites = VALUES(invites);';
            $this->db->query($query);

            // 実行
            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
        }

        public function findColumns(){
            $query = "SELECT column_name FROM information_schema.columns WHERE TABLE_SCHEMA=:dbname AND table_name=:tbname"; 
            $this->db->query($query);
            $this->db->bind(':dbname', "xxx");
            $this->db->bind(':tbname', "members");

            return $this->db->resultSet();
        }

        // イベントカウントアップデート
        public function updateEvents($data) {
            $query = "UPDATE members SET events = :events WHERE uid = :uid;";
            $this->db->query($query);

            $this->db->bind(':events', $data->events);
            $this->db->bind(':uid', $data->uid);

            // 実行
            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
        }

        // アンケートカウントアップデート
        public function updateEnquetes($data) {
            $query = "UPDATE members SET enquetes = :enquetes WHERE uid = :uid;";
            $this->db->query($query);

            $this->db->bind(':enquetes', $data->enquetes);
            $this->db->bind(':uid', $data->uid);

            // 実行
            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
        }


    }