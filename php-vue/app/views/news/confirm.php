<?php require APP_ROOT . '/views/includes/head.php'; ?>
<div id="app">
<div class="container">
    <div class="row form">
            <div class="subheader">
                <h3>◯◯　お知らせ　登録</h3>
            </div>
            <?php if(!empty($data)): ?>
            <div class="row">
                <div class="input-field">
                <h6>お知らせの文言</h6>
                <p id="item"><?php echo $data['item']; ?></p>
                </div>
            </div>
            <div class="divider"></div>
            <div class="row">
                <h6>リンク先の種類を選択</h6>
                <p id="target"><?php echo $data['target'] ;?></p>
            </div>
            <div class="divider"></div>
            <div v-show="target === '外部サイトリンクURL'" class="row">
                <h6>外部サイトリンクURL</h6>
                <p id="link"><?php echo $data['link']; ?></p>
            </div>
            <div v-show="target === '◯◯内部リンクURL'" class="row">
                <h6>◯◯内部リンクURL</h6>
                <p id="link"><?php echo $data['link']; ?></p>
            </div>
            <div class="divider"></div>
            <div class="row">
            <h6>公開日時</h6>
            <p id="published"><?php echo $data['published']; ?></p>
            </div>
            <div class="divider"></div>
            <div class="row">
            <h6>表示・非表示</h6>
                <?php if($data['status'] === true): ?>
                    <p id="status" class="label-typo">表示</p>
                <?php else: ?>
                    <p id="status" class="label-typo">非表示</p>
                <?php endif; ?>
            </div>

            <div class="row btn-fluid">
                <div class="col s8">
                    <a href="<?php echo URL_ROOT; ?>/news/create" class="waves-effect waves-light btn-large">
                        修正する
                    </a>
                </div>
                <div class="col s8">
                    <a class="waves-effect waves-light btn-large" @click="addNews">
                        登録する
                    </a>
                </div>
            </div>
            <?php else:?>
                <div class="row">
                    <p class="center-align">ブラウザの「戻る」ボタンで、戻らないでください。</p>
                    <div class="row btn-fluid">
                    <div class="col s8">
                        <a class="waves-effect waves-light btn-large" href="<?php echo URL_ROOT; ?>/news">
                            お知らせ Topへ
                        </a>
                    </div>
                </div>
                </div>
            <?php endif;?>
    </div>
</div>
</div>

<script text="text/babel">
<?php if(isset($data['id'])): ?>
const id = '<?php echo $data['id']; ?>';
<?php endif; ?>
const pablished = document.getElementById('published').textContent;
const item = document.getElementById('item').textContent;
const target = document.getElementById('target').textContent;
const link = document.getElementById('link').textContent;
const status = document.getElementById('status').textContent;
const app = new Vue({
    el: "#app",
    data: {
        published: pablished,
        item: item,
        status: status,
        link: link,
        target: target
    },
    methods: {
        addNews(){
            if(app.published){
                app.published = moment(app.published).format('YYYY-MM-DD');
            }
            if(app.target === '外部サイトリンクURL'){
                app.target = '_blank';
            } else if(app.target === 'ミーティングルーム'){
                app.link = '/mtgroom/';
                app.target = null;
            } else if(app.target === 'ポテトブログ'){
                app.link = '/potatoblog/';
                app.target = null;
            } else if(app.target === '◯◯内部リンクURL'){
                app.target = null;
            } else {
                app.link = null;
                app.target = null;
            }

            if(app.status === '表示'){
                app.status = '1';
            } else {
                app.status = '0';
            }
            let data = {};
            if(typeof(id) !== "undefined"){
                data = {
                    id: id,
                    published: app.published,
                    item: app.item,
                    link: app.link,
                    target : app.target,
                    status: app.status
                };
            } else {
                data = {
                    published: app.published,
                    item: app.item,
                    link: app.link,
                    target : app.target,
                    status: app.status
                };
            }

            axios.post('<?php echo URL_ROOT; ?>/api/newsInfo', {
                data
            })
            .then(function(response){
                console.log(response);
                location.href = '<?php echo URL_ROOT; ?>/news/complete';
            })
            .catch(function(error){
                console.log(error);
            })
        }
    }
});

</script>

<?php require APP_ROOT . '/views/includes/footer.php'; ?>