<?php
    class Members extends Controller {
        public function __construct() {
            $this->memberModel = $this->model('Member');
        }

        public function index(){
            if (!isLoggedIn()){
                redirect('index');
            }
            $members =  $this->memberModel->findMembers();
            // $tbcolumns = $this->memberModel->findColumns();
            $columns = ["ID", "ニックネーム", "招待数", "招待された", "商品アンケート数", "MTGアンケート数", "イベント参加回数", "投稿回数", "チップス", "袋数", "レベル", "合計チップス", "登録日"];
            $data = [
                'page' => 'points',
                'members' => $members,
                'columns' => $columns,
            ];
            $this->view('members/index', $data);
        }

    }