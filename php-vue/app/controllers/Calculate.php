<?php
    class Calculate extends Controller {
        public function __construct() {
            $this->memberModel = $this->model('Member');
            $this->postModel = $this->model('Post');
            $this->inviteModel = $this->model('Invite');
            $this->eventModel = $this->model('Event');
            $this->enqueteModel = $this->model('Enquete');
        }

        public function index(){
            echo '◯◯';
        }

        // ポイント集計
        public function chips(){
            $members = $this->memberModel->findMembers();
            $uid_chipsTotal = [];

            foreach($members as $member){
                $chips_total =
                    $member->posts +
                    $member->invites * 3 +
                    $member->invited * 3 +
                    $member->product * 5 +
                    $member->mtgroom * 5 +
                    $member->enquetes * 5 +
                    $member->events * 10;

                $bags = floor($chips_total / 30);

                $chips;
                if($chips_total < 30){
                    $chips = $chips_total;
                } else {
                    $chips = $chips_total - ($bags * 30);
                }  

                $uid_chipsTotal[] = [
                    'uid' => $member->uid,
                    'chips' => $chips,
                    'bags' => $bags,
                    'chips_total' => $chips_total,
                    'level' => $bags
                ];
            }

            $this->memberModel->upsertChipsTotal($uid_chipsTotal);
        }

        public function sns(){
            $uids = $this->memberModel->findUids();
            $uids_str = implode($uids, ', ');

            $data = [
                'hashtag' => '%#◯◯%',
                'program_id' => PROGRAM_ID,
                'daily_max_count' => 1,
                'start' => '2020-07-13 16:00:00',
                'uids' => $uids_str
            ];

            // 投稿回数取得
            $count = $this->postModel->getSnsPostCount($data);

            // 投稿回数 ➡︎ db更新
            $this->memberModel->updateSnsPostCount($count);

        }

        public function tags(){
            $tags = $this->user_tags();

            $this->memberModel->updateMtgroom($tags);
            $this->memberModel->updateProduct($tags);
        }


        public function user_tags(){
            $users = $this->user_data();

            $user_tags = [];

            /**
             * 正規表現パターン
             */

            // ミーティングルームタグ→mtgsurvey29(xxx)以降
            $mtg_pattern = '/\bmtgsurvey(2[9]|[3-9]\d+|\d{3,})\(xxx\)/';

            // 商品アンケートタグ→survey31(xxx)以降
            $prod_pattern = '/\bsurvey(3[1-9]|[4-9]\d+|\d{3,})\(xxx\)/';
            // $prod_pattern = '/\bsurvey(3[1-9]|[4-9]\d+|[1-9]\d{2,})\(xxx\)/';

            foreach($users as $user){
                $tags = $user['tags'];
                $tagnames = array_column($tags, 'tag_name');
                $filtered_tags = [];
                $mtg_tags = [];
                $prod_tags = [];
                foreach($tagnames as $tag){
                    // mtg match
                    preg_match($mtg_pattern, $tag, $mp);
                    preg_match($prod_pattern, $tag, $pp);
                    if(isset($mp[0])){
                        $mtg_tags[] = $tag;
                    }
                    if(isset($pp[0])){
                        $prod_tags[] = $tag;
                    }


                }
                $filtered_tags['uid'] = $user['id'];
                $filtered_tags['tags']['mtgroom'] = $mtg_tags; 
                $filtered_tags['tags']['product'] = $prod_tags;
                if(count($mtg_tags) > 0 || count($prod_tags) > 0){
                    $user_tags[] = $filtered_tags;
                }
            }

            return $user_tags;
        }

        // apiからユーザー情報を取得
        public function user_data(){
            $endpoint = 'https://xxx';
            $users_json = curl($endpoint);
            $decoded = json_decode($users_json, true);
            $users = $decoded['data'];

            while (isset($decoded['nextUrl'])) {
                $api_response = curl($decoded['nextUrl']);
                $decoded = json_decode($api_response, true);
                $users = array_merge($users, $decoded['data']);
            }

            return $users;
        }

        public function invites(){
            $invites = $this->memberModel->findInvites();

            $this->memberModel->updateInvites($invites);
        }

        // イベント参加カウント
        public function events() {
            $events = $this->eventModel->findEvents();
            foreach ($events as $event) {
                $this->memberModel->updateEvents($event);
            }
        }

        // アンケート答えカウント
        public function enquetes() {
            $enquetes = $this->enqueteModel->findEnquetes();
            foreach ($enquetes as $enquete) {
                $this->memberModel->updateEnquetes($enquete);
            }
        }

    }
