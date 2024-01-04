<?php
    class Api extends Controller {
        public function __construct() {
            $this->memberModel = $this->model('Member');
            $this->bagModel = $this->model("Bag");
            $this->roomModel = $this->model("Room");
            $this->blogModel = $this->model("Blog");
            $this->inviteModel = $this->model("Invite");
            $this->newsModel = $this->model("Info");
        }

        public function index(){
            echo SITE_NAME;
        }

        public function uid(){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                $uid = $_POST['uid'];
                $nickname = $_POST['nickname'];

                $_SESSION['uid'] = $uid;
                $_SESSION['nickname'] = $nickname;
                $_SESSION['created'] = $_POST['created'];

                $data = [
                    'uid' => $uid,
                    'nickname' => $_SESSION['nickname'],
                    'created' => $_SESSION['created']
                ];

                $member = $this->memberModel->findMember($uid);

                if(empty($member)){
                    $this->memberModel->addMember($uid);
                } else {
                    if($member->nickname !== $nickname){
                        $params = [
                            'uid' => $uid,
                            'nickname' => $nickname,
                        ];
                        $this->memberModel->updateNickname($params);
                    }
                }

                $_SESSION['level'] = $member->level;
                $_SESSION['chips'] = $member->chips;
                $_SESSION['bag_img'] = $member->img;
                $_SESSION['bags'] = $member->bags;

                $data = ['uid' => $uid];

                echo json_encode($data);
            }
        }

        public function card(){

            $uid = $_SESSION['uid'];
            $nickname = $_SESSION['nickname'];
            $chips = $_SESSION['chips'];
            $level = $_SESSION['level'];
            $bag_img = $_SESSION['bag_img'];
            $created = $_SESSION['created'];
            $card_template = img('card/template.png');

            $params = [
                'card' => $card_template,
                'uid' => $uid,
                'nickname' => $nickname,
                'created' => $created,
                'chips' => $chips,
                'bag' => $bag_img,
                'level' => $level
            ];

            // カード生成
            $card = generateCard($params);

            echo json_encode($params);
        }

        public function bag(){
            $mypagepath = dirname(dirname(dirname(dirname(dirname(__FILE__))))) . BAGS_IMG_PATH;
            $thumbnailPath = dirname(dirname(dirname(dirname(dirname(__FILE__))))) . BAGS_THUM_PATH;
            $new_img;
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $_POST = json_decode(file_get_contents("php://input"),true);

                $filename = $_POST['data']['filename'];
                $imagedata = isset($_POST['data']['image']) ? $_POST['data']['image'] : NULL;
                $special= $_POST['data']['special'];
                $start= isset($_POST['data']['start']) ? $_POST['data']['start'] : NULL;
                $end= isset($_POST['data']['end']) ? $_POST['data']['end'] : NULL;
                $status= $_POST['data']['status'];

                $bags = $this->bagModel->countBags();
                $sort = intval($bags->count) + 1;
                $data = [
                    'filename' => $filename,
                    'special' => $special,
                    'start' => $start,
                    'end' => $end,
                    'status' => $status,
                    'sort' => $sort
                ];

                if(!is_null($imagedata)){

                    // convert base encode to img
                    $temp_img = imagecreatefromstring(base64_decode($imagedata));
                    imagesavealpha($temp_img, true);

                    //Save png image
                    ImagePNG($temp_img, DIR_ROOT . '/public/img/'. $filename .'.png');

                    // mv img from admin to mypage
                    $new_img = DIR_ROOT . '/public/img/'. $filename .'.png';

                    // 画像リサイズ（thumbnail化）50x65
                    $width = 120;
                    $height = 153;
                    $width_thumb = 50;
                    $height_thumb = 65;

                    $thumbnail_p = imagecreatetruecolor($width_thumb, $height_thumb);
                    $thumbnail = imagecreatefrompng($new_img);
                    imagesavealpha($thumbnail, true);
                    imagecopyresampled($thumbnail_p, $thumbnail, 0, 0, 0, 0, $width_thumb, $height_thumb, $width, $height);

                    $mypagepath = $mypagepath . $filename . '.png';
                    //exec("mv $new_img $mypagepath");
                    if(copy($new_img, $mypagepath)){
                        $out = 'true';
                        $code = '200';
                    } else {
                        $out = 'false';
                        $code = '500';
                    }


                    // Save thumb image
                    ImagePNG($thumbnail, DIR_ROOT . '/public/img/'. $filename .'.png');
                    $thumbnailPath = $thumbnailPath . $filename . '.png';
                    if(copy($new_img, $thumbnailPath)){
                        $out = 'true';
                        $code = '200';
                    } else {
                        $out = 'false';
                        $code = '500';
                    }

                    $data['img'] = $filename . '.png';
                } else {
                    // rename png img
                    $before_img = DIR_ROOT . '/public/img/'. $_POST['data']['beforeFilename'] .'.png';
                    $edit_img = DIR_ROOT . '/public/img/'. $filename .'.png';
                    $beforemypagepath = $mypagepath . $_POST['data']['beforeFilename'] . '.png';
                    $mypagepath = $mypagepath . $filename . '.png';
                    $data['img'] = $filename . '.png';
                    if(rename($before_img, $edit_img) && rename($beforemypagepath, $mypagepath)){
                        $out = 'true';
                        $code = '200';
                    } else {
                        $out = 'false';
                        $code = '500';
                    }

                    // rename thumbnail png
                    $beforeThumbpath = $thumbnailPath . $_POST['data']['beforeFilename'] . '.png';
                    $thumbpath = $thumbnailPath . $filename . '.png';
                    $data['img'] = $filename . '.png';
                    if(rename($beforeThumbpath, $thumbpath)){
                        $out = 'true';
                        $code = '200';
                    } else {
                        $out = 'false';
                        $code = '500';
                    }
                }

                $upsert;
                if(isset($_POST['data']['id'])){
                    $data['id'] = $_POST['data']['id'];
                    $upsert = $this->bagModel->updateBag($data);
                } else {
                    $upsert = $this->bagModel->addBag($data);
                }

                $response;
                if($upsert && $out){
                    $response = [
                        'code' => $code,
                        'mypagePath' => $mypagepath,
                        'imgsave' => $out,
                        'message' => 'プロフィール画像は正常に登録されました。'
                    ];
                } else {
                    $response = [
                        'code' => 500,
                        'mypagePath' => $mypagepath,
                        'imgsave' => $out,
                        'message' => 'プロフィール画像は登録に失敗しました。'
                    ];
                }
                echo json_encode($response);
            }
        }

        public function bagSort(){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $_POST = json_decode(file_get_contents("php://input"),true);
                $data = $_POST['data'];

                $update = $this->bagModel->updateSort($data);

                $response = [];
                if($update){
                    $bags = $this->bagModel->getBags();
                    $response = [
                        'bags' => $bags,
                        'code' => 200,
                        'message' => '並び順変更しました。'
                    ];
                } else {
                    $response = [
                        'code' => 500,
                        'message' => '並び順更新失敗しました。'
                    ];
                }

                echo json_encode($response);
            }
        }

        public function bags(){
            $response;
            if($_SERVER['REQUEST_METHOD'] == 'GET'){
                $bags = $this->bagModel->getBags();
                $response = [
                    'bags' => $bags
                ];
            } else if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $_POST = json_decode(file_get_contents("php://input"),true);

                $id = $_POST['id'];

                if($_POST['type'] == 'special'){
                    $special = $_POST['special'];
                    $data = [
                        'id' => $id,
                        'special' => $special
                    ];
                    $update = $this->bagModel->updateSpecial($data);
                    if($update){
                        $bag = $this->bagModel->getBag($id);
                        $response = [
                            'code' => 200,
                            'message' => 'Bag ID ' . $id . ' special updated to ' . $bag->special,
                            'id' => $bag->id,
                            'special' => $bag->special
                        ];
                    } else {
                        $response = [
                            'code' => 500,
                            'message' => 'Bag ID ' . $id . ' special update failed'
                        ];
                    }

                } else if($_POST['type'] == 'status'){
                    $status = $_POST['status'];
                    $data = [
                        'id' => $id,
                        'status' => $status
                    ];
                    $update = $this->bagModel->updateStatus($data);
                    if($update){
                        $bag = $this->bagModel->getBag($id);
                        $response = [
                            'code' => 200,
                            'message' => 'Bag ID ' . $id . ' status updated to ' . $bag->special,
                            'id' => $bag->id,
                            'status' => $bag->status
                        ];
                    } else {
                        $response = [
                            'code' => 500,
                            'message' => 'Bag ID ' . $id . ' status update failed'
                        ];
                    }
                } else if($_POST['type'] == 'delete'){
                    $delete = $this->bagModel->deleteBag($id);
                    $bagsids = array();
                    if($delete){
                        $length = $this->bagModel->countBags();
                        $length = $length->count;
                        $getResults = $this->bagModel->getBags();
                        $getResults = json_decode(json_encode($getResults), true);

                        foreach($getResults as $key => $val){
                            array_push($bagsids, $val['id']);
                        }

                        $getSortResults = $this->bagModel->afterDeleteSort($bagsids, $length);
                        if($getSortResults){
                            $response = [
                                'ids' => $bagsids,
                                'length' => $length,
                                'code' => 200,
                                'message' => 'Bag ID ' . $id . ' deleted',
                                'sortResult' => $getSortResults
                            ];
                        }
                    } else {
                        $response = [
                            'code' => 500,
                            'message' => 'Bag ID ' . $id . ' failed to delete'
                        ];
                    }
                }
            }

            echo json_encode($response);
        }

        public function member(){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $uid = $_SESSION['uid'];
                $bag_id = $_POST['bag_id'];

                $data = [
                    'uid' => $uid,
                    'bag_id' => $bag_id,
                ];

                $memberBag = $member = $this->memberModel->findBagId($uid);

                $response = [];

                if ($bag_id != $memberBag->bag_id){
                    $updateMember = $this->memberModel->updateBagId($data);
                    if(!$updateMember){
                        $response['code'] = 500;
                    } else {
                        $member = $this->memberModel->findMember($uid);
                        $_SESSION['bag_img'] = $member->img;
                        $response['code'] = 200;
                    }
                }

                echo json_encode($response);

            }
        }

        public function members(){
            if($_SERVER['REQUEST_METHOD'] == 'GET'){
                $members = $this->memberModel->findMembers();
                $data = [
                    'members' => $members
                ];

                echo json_encode($data);
            }
        }

        public function mtgroom_status(){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                var_dump($_POST);
                $response = [
                    'status' => 'status'
                ];
                echo json_encode($response);
            }
        }


        public function rooms(){
            $response;
            if($_SERVER['REQUEST_METHOD'] == 'GET'){
                $rooms = $this->roomModel->getAllRooms();
                $response = [
                    'rooms' => $rooms
                ];
            } else if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $_POST = json_decode(file_get_contents("php://input"),true);

                $id = $_POST['id'];

                if($_POST['type'] == 'status'){
                    $status = $_POST['status'];
                    $data = [
                        'id' => $id,
                        'status' => $status
                    ];
                    $update = $this->roomModel->updateStatus($data);
                    if($update){
                        $room = $this->roomModel->getRoom($id);
                        $response = [
                            'code' => 200,
                            'message' => 'Room ID ' . $id . ' status updated to ' . $room->status,
                            'id' => $room->id,
                            'status' => $room->status
                        ];
                    } else {
                        $response = [
                            'code' => 500,
                            'message' => 'Room ID ' . $id . ' status update failed'
                        ];
                    }
                } else if($_POST['type'] == 'delete'){
                    $delete = $this->roomModel->deleteRoom($id);
                    if($delete){
                        $response = [
                            'code' => 200,
                            'message' => 'Room ID ' . $id . ' deleted'
                        ];
                    } else {
                        $response = [
                            'code' => 500,
                            'message' => 'Room ID ' . $id . ' failed to delete'
                        ];
                    }
                }

            }

            echo json_encode($response);
        }

        public function blogs(){
            $response;
            if($_SERVER['REQUEST_METHOD'] == 'GET'){
                $blogs = $this->blogModel->getAllBlogs();
                $response = [
                    'blogs' => $blogs
                ];
            } else if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $_POST = json_decode(file_get_contents("php://input"),true);

                $id = $_POST['id'];

                if($_POST['type'] == 'status'){
                    $status = $_POST['status'];
                    $data = [
                        'id' => $id,
                        'status' => $status
                    ];
                    $update = $this->blogModel->updateStatus($data);
                    if($update){
                        $blog = $this->blogModel->getBlog($id);
                        $response = [
                            'code' => 200,
                            'message' => 'Blog ID ' . $id . ' status updated to ' . $blog->status,
                            'id' => $blog->id,
                            'status' => $blog->status
                        ];
                    } else {
                        $response = [
                            'code' => 500,
                            'message' => 'Blog ID ' . $id . ' status update failed'
                        ];
                    }
                } else if($_POST['type'] == 'delete'){
                    $delete = $this->blogModel->deleteBlog($id);
                    if($delete){
                        $response = [
                            'code' => 200,
                            'message' => 'Blog ID ' . $id . ' deleted'
                        ];
                    } else {
                        $response = [
                            'code' => 500,
                            'message' => 'Blog ID ' . $id . ' failed to delete'
                        ];
                    }
                }

            }

            echo json_encode($response);
        }
        // お知らせ取得・ステータス更新・削除
        public function news(){
            $response;
            if($_SERVER['REQUEST_METHOD'] == 'GET'){
                $news = $this->newsModel->getNewsItems();
                $response = [
                    'news' => $news
                ];
            } else if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $_POST = json_decode(file_get_contents("php://input"),true);

                $id = $_POST['id'];

                if($_POST['type'] == 'status'){
                    $status = $_POST['status'];
                    $data = [
                        'id' => $id,
                        'status' => $status
                    ];
                    $update = $this->newsModel->updateStatus($data);
                    if($update){
                        $news = $this->newsModel->getNewsItem($id);
                        $response = [
                            'code' => 200,
                            'message' => 'News ID ' . $id . ' status updated to ' . $news->status,
                            'id' => $news->id,
                            'status' => $news->status
                        ];
                    } else {
                        $response = [
                            'code' => 500,
                            'message' => 'News ID ' . $id . ' status update failed'
                        ];
                    }
                } else if($_POST['type'] == 'delete'){
                    $delete = $this->newsModel->deleteNewsItem($id);
                    if($delete){
                        $response = [
                            'code' => 200,
                            'message' => 'News ID ' . $id . ' deleted'
                        ];
                    } else {
                        $response = [
                            'code' => 500,
                            'message' => 'News ID ' . $id . ' failed to delete'
                        ];
                    }
                }
            }

            echo json_encode($response);
        }
        // お知らせ 登録
        public function newsInfo(){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $_POST = json_decode(file_get_contents("php://input"),true);

                $published = $_POST['data']['published'];
                $item = $_POST['data']['item'];
                $link= $_POST['data']['link'];
                $target= $_POST['data']['target'];
                $status= $_POST['data']['status'];


                $data = [
                    'published' => $published,
                    'item' => $item,
                    'link'=> $link,
                    'target'=>$target,
                    'status' => $status
                ];

                $upsert;
                if(isset($_POST['data']['id'])){
                    $data['id'] = $_POST['data']['id'];
                    $upsert = $this->newsModel->updateNews($data);
                } else {
                    $upsert = $this->newsModel->addNews($data);
                }

                $response = [];
                if($upsert){
                    $response = [
                        'code' => 200,
                        'message' => 'お知らせは正常に登録されました。 '
                    ];
                } else {
                    $response = [
                        'code' => 500,
                        'message' => 'お知らせはの登録に失敗しました。 '
                    ];
                }
                echo json_encode($response);
            }
        }

        // 登録フォームからget送信
        public function invite($invite_uid, $invited_uid){
            $response = [];
            if($_SERVER['REQUEST_METHOD'] == 'GET'){
                $this->cors();
                $invite_user_id = decryptUid($invite_uid);
                $invited_user_id = decryptUid($invited_uid);

                $data = [
                    'invite_uid' => $invite_user_id,
                    'invited_uid' => $invited_user_id
                ];

                $add = $this->inviteModel->addInvite($data);
                if($add){
                    $response['code'] = 200;
                    $response['message'] = 'Invites update success';
                } else {
                    $response['code'] = 500;
                    $response['message'] = 'Invites update failed';
                }
                echo json_encode($response);
            } else {
                $response['code'] = 500;
                $response['message'] = 'Incorrect get parameters';
                echo json_encode($response);
                exit;
            }

        }


        public function cors(){

            // Allow from any origin
            if (isset($_SERVER['HTTP_ORIGIN'])) {
                header('Access-Control-Allow-Origin: ' . DOMAIN_FORM );
                header('Access-Control-Allow-Credentials: true');
                header('Access-Control-Max-Age: 86400');    // cache for 1 day
            }
        
            // Access-Control headers are received during OPTIONS requests
            if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        
                if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
                    // may also be using PUT, PATCH, HEAD etc
                    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         
        
                if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
                    header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

                exit(0);
            }
        
        }

    }