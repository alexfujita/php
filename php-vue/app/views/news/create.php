<?php require APP_ROOT . '/views/includes/head.php'; ?>
<div id="app">
<div class="container">
    <div class="row form">
        <form action="<?php echo URL_ROOT; ?>/news/confirm" @submit="checkForm" method="post">
            <div class="subheader">
                <h3>◯◯　お知らせ　登録</h3>
            </div>

            <div class="row">
            <div class="input-field">
                    <input v-model="item" id="item" name="item" placeholder="例：「ポテトブログ」を更新しました。" />
                    <label for="item">お知らせの文言</label>
            </div>
            </div>

            <div class="row">
                <p class="label-typo">リンク先の種類を選択</p>
                <div class="input-field s4">
                    <select class="browser-default" v-model="target" name="target">
                        <option v-for="target in targetTypes">{{ target }}</option>
                    </select>
                </div>
            </div>

            <div v-show="target === '外部サイトリンクURL'" class="row">
                <div class="input-field">
                    <input v-model="link" id="link" placeholder="例：https://www.calbee.co.jp/" name="link" />
                    <label for="link">外部サイトリンクURL</label>
                </div>
            </div>

            <div v-show="target === '◯◯内部リンクURL'" class="row">
                <div class="input-field">
                    <input v-model="link" id="link" placeholder="例：/potatoblog/2020-06-26-456" name="link" />
                    <label for="link">◯◯内部リンクURL</label>
                </div>
                <p class="label-typo">例：<br>ミーテイングルーム「アーカイブ」の場合　「/mtgroom/archive/vol27」<br>歴代の味の場合　「/taste/」<br>ポテトブログ「アーカイブ」の場合　「/potatoblog/2020-06-26-456」</p>
            </div>

            <div class="row">
            <p class="label-typo">公開日時</p>
            <vuejs-datepicker 
            v-model="defaultDay"
            :format="DatePickerFormat"
            :language="ja"
            name="datepicker"
            id="input-id"
            input-class="input-class"></vuejs-datepicker>
            </div>
            <div class="row">
            <p class="label-typo">表示・非表示</p>
                <div class="switch">
                    <label>
                        <input type="checkbox" v-model="status" name="status">
                        <span class="lever"></span><span v-bind:class="{ 'teal-text lighten-5' : status === true }">表示</span>
                    </label>
                </div>
            </div>
            <div v-if="errors.length" class="row error--Block">
                <p class="error--Text">{{errorItem}}</p>
                <p class="error--Text">{{errorlink}}</p>
            </div>
            <div class="row btn-fluid">
                <button id="btn-confirm" class="btn waves-effect waves-light btn-large" type="submit" name="action">確認</button>
            </div>
        </form>
    </div>
</div>
</div>

<script text="text/babel">
let day = new Date();
let today = moment(day).format('YYYY-MM-DD');
const btnConfirm = document.getElementById('btn-confirm');
<?php if(isset($_SESSION['item'])):?>
const dataItem = '<?php echo $_SESSION['item'] ;?>';
const dataLink = '<?php echo $_SESSION['link'] ;?>';
const dataTarget = '<?php echo $_SESSION['target'] ;?>';
const dataPublished = '<?php echo $_SESSION['published'] ;?>';
const dataStatus = '<?php echo $_SESSION['status'] ;?>';
const app = new Vue({
    el: "#app",
    data: {
        errorItem: '',
        errorlink: '',
        errors:[],
        defaultDay: dataPublished,
        DatePickerFormat: 'yyyy-MM-dd',
        ja: vdp_translation_ja.js,
        item: dataItem,
        status: dataStatus,
        link: dataLink,
        target: dataTarget,
        targetTypes: [
            '選択してください',
            'ミーティングルーム',
            'ポテトブログ',
            '◯◯内部リンクURL',
            '外部サイトリンクURL',
            'リンクなし'
        ]
    },
    components: {
        'vuejs-datepicker':vuejsDatepicker
    },
    methods:{
        checkForm(e){
            if(this.item){
                if(this.target === '◯◯内部リンクURL' && this.link){
                    return true
                } else if(this.target === '外部サイトリンクURL' && this.link){
                    return true
                }
            }

            if(!this.item){
                this.errorItem = 'お知らせの文言を入力してください';
                this.errors.push('item');
                e.preventDefault();
            }
            if(this.target === '◯◯内部リンクURL' && this.link === null){
                this.errorlink = '◯◯内部リンクURLを入力してください';
                this.errors.push('insideLink');
                e.preventDefault();
            }
            if(this.target === '外部サイトリンクURL' && this.link === null){
                this.errorlink = '外部サイトリンクURLを入力してください';
                this.errors.push('outsideLink');
                e.preventDefault();
            }
        }
    }
 });
<?php else: ?>
const app = new Vue({
    el: "#app",
    data: {
        errorItem: '',
        errorlink: '',
        errors:[],
        defaultDay: today,
        DatePickerFormat: 'yyyy-MM-dd',
        ja: vdp_translation_ja.js,
        item: null,
        status: false,
        link: null,
        target: '選択してください',
        targetTypes: [
            '選択してください',
            'ミーティングルーム',
            'ポテトブログ',
            '◯◯内部リンクURL',
            '外部サイトリンクURL',
            'リンクなし'
        ]
    },
    components: {
        'vuejs-datepicker':vuejsDatepicker
    },
    methods:{
        checkForm(e){
            if(this.item){
                if(this.target === '◯◯内部リンクURL' && this.link){
                    return true
                } else if(this.target === '外部サイトリンクURL' && this.link){
                    return true
                }
            }

            if(!this.item){
                this.errorItem = 'お知らせの文言を入力してください';
                this.errors.push('item');
                e.preventDefault();
            }
            if(this.target === '◯◯内部リンクURL' && this.link === null){
                this.errorlink = '◯◯内部リンクURLを入力してください';
                this.errors.push('insideLink');
                e.preventDefault();
            }
            if(this.target === '外部サイトリンクURL' && this.link === null){
                this.errorlink = '外部サイトリンクURLを入力してください';
                this.errors.push('outsideLink');
                e.preventDefault();
            }
        }
    }
 });
<?php endif; ?>
</script>

<?php require APP_ROOT . '/views/includes/footer.php'; ?>