<?php
    class Post {
        private $db;

        public function __construct() {
            $this->db = new Database('login');
        }

        public function fetchTweets($uid){
            $query = "SELECT post_body as body, tweet_created_at as created FROM filtered_tweets WHERE user_id = :uid AND program_id = :program_id ORDER BY tweet_created_at DESC;";
            $this->db->query($query);

            $this->db->bind(':uid', $uid);
            $this->db->bind(':program_id', PROGRAM_ID);

            return $this->db->resultSet();
        }

        public function fetchInstagramPosts($uid){
            $query = "SELECT caption_text as body, media_url as img, post_created as created FROM kns_filtered_instagram_posts WHERE user_id = :uid AND program_id = :program_id ORDER BY post_created DESC;";
            $this->db->query($query);

            $this->db->bind(':uid', $uid);
            $this->db->bind(':program_id', PROGRAM_ID);

            return $this->db->resultSet();
        }

        public function fetchBlogPosts($uid){
            $query = "SELECT post_description as body, post_created_at as created FROM kns_filtered_blog_posts WHERE user_id = :uid AND program_id = :program_id ORDER BY post_created_at DESC;";
            $this->db->query($query);

            $this->db->bind(':uid', $uid);
            $this->db->bind(':program_id', PROGRAM_ID);

            return $this->db->resultSet();
        }


        public function getSnsPostCount($data) {
            $uids = $data['uids'];
            $query = <<<SQL
                select
                user_id,
                sum(count) as count
                from (
                select
                    ifnull(ig.user_id, tw.user_id) as user_id,
                    if (
                        ifnull(ig.count, 0) + ifnull(tw.count, 0) < :daily_max_count,
                        ifnull(ig.count, 0) + ifnull(tw.count, 0),
                        :daily_max_count
                    ) as count
                from master_dates dates
                
                left join (
                    select
                    id
                    from
                    users
                    where pid = :program_id
                ) users
                on 1 = 1
            
                left join (
                    select
                        user_id,
                        date(tweet_created_at) as date,
                        count(tweet_id) as count
                    from
                        filtered_tweets as t
                    where
                        program_id = :program_id
                    and post_body LIKE :hashtag
                    and tweet_created_at >= :start
                    and t.user_id in ($uids)
                    group by
                        user_id,
                        date(tweet_created_at)
                ) tw
                on
                    dates.date = tw.date
                    and users.id = tw.user_id
            
                left join (
                    select
                        user_id,
                        date(post_created) as date,
                        count(id) as count
                    from
                        kns_filtered_instagram_posts as i
                    where
                        program_id = :program_id
                    and (caption_text LIKE :hashtag
                        or tag LIKE :hashtag)
                    and post_created >= :start
                    and i.user_id in ($uids)
                    group by
                    user_id,
                    date(post_created)
                ) ig
                on
                    dates.date = ig.date
                    and users.id = ig.user_id
            
                left join (
                    select
                        user_id,
                        date(post_created_at) as date,
                        count(id) as count
                    from
                        kns_filtered_blog_posts as b
                    where
                        program_id = :program_id
                    and (post_title LIKE :hashtag or post_description LIKE :hashtag)
                    and post_created_at >= :start
                    and b.user_id in ($uids)
                    group by
                        user_id,
                        date(post_created_at)
                ) blog
                    on
                        dates.date =  blog.date
                        and users.id = blog.user_id
                        
                where
                    dates.date >= '2020-07-13'
                group by 
                    user_id,
                    dates.date
                ) sq
                where
                user_id is not null
                
                group by
                user_id;
SQL;


            $this->db->query($query);

            // パラメタをバインド
            $this->db->bind(':hashtag', $data['hashtag']);
            $this->db->bind(':program_id', $data['program_id']);
            $this->db->bind(':start', $data['start']);
            $this->db->bind(':daily_max_count', $data['daily_max_count']);

            $result = $this->db->resultArr();
            // $this->db->debugSql();

            return $result;

        }
    }