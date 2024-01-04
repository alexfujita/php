<?php require APP_ROOT . '/views/includes/head.php'; ?>
<div id="app">
<div class="container">
    <div class="row form">
        <form action="<?php echo URL_ROOT; ?>/news/confirm" method="post">
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
                    <input v-model="link" id="link" placeholder="例：potatoblog/2020-06-26-456" name="link" />
                    <label for="link">◯◯内部リンクURL</label>
                </div>
                <p class="label-typo">例：<br>ミーテイングルーム「アーカイブ」の場合　「/mtgroom/archive/vol27」<br>歴代の味の場合　「/taste/」<br>ポテトブログ「アーカイブ」の場合　「/potatoblog/2020-06-26-456」</p>
            </div>

            <div class="row">
            <p class="label-typo">公開日時</p>
            <vuejs-datepicker 
            v-model="published"
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

            <div class="row btn-fluid">
                <button class="btn waves-effect waves-light btn-large" type="submit" name="action">確認</button>
            </div>
            <input type="hidden" name="id" v-model="id">
        </form>
    </div>
</div>
</div>

<script text="text/babel">

const app = new Vue({
    el: "#app",
    data: {
        id: null,
        published: null,
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
    watch: {
      target:function(val){
        if(val === '外部サイトリンクURL' || val === '◯◯内部リンクURL'){
          if(this.link === '/mtgroom/' || this.link === '/potatoblog/'){
            this.link = null;
          }
        }
      },
    },
    created: function(){
        this.getNews()
      },
    methods: {
      getNews: function(){
        <?php if(isset($data['item'])):?>
          const id = '<?php echo $data['id']; ?>';
          const item = '<?php echo $data['item']; ?>';
          const published = '<?php echo $data['published']; ?>';
          let target = '<?php echo $data['target']; ?>';
          let link = '<?php echo $data['link']; ?>';
          let status = '<?php echo $data['status']; ?>';
        <?php else: ?>
          const id = '<?php echo $data['news']->id; ?>';
          const item = '<?php echo $data['news']->item; ?>';
          const published = '<?php echo $data['news']->published ;?>';
          let target = '<?php echo $data['news']->target; ?>';
          let link = '<?php echo $data['news']->link; ?>';
          let status = '<?php echo $data['news']->status; ?>';
        <?php endif; ?>
          if(status === '1'){
            status = true;
          } else {
            status = false;
          }
          const reg = new RegExp('mypage\/xxx');
          const matchReg = link.match(reg);
          console.log(reg);
          if(matchReg){
            console.log(matchReg);
            target = '◯◯内部リンクURL';
          } else if(link === '/mtgroom/'){
            target = 'ミーティングルーム';
          } else if(link === '/potatoblog/'){
            target = 'ポテトブログ';
          } else if (link === ''){
            target = 'リンクなし';
          }

          if(target === '_blank'){
            target = '外部サイトリンクURL'
          }

          this.id = id;
          this.item = item;
          this.published = published;
          this.target = target;
          this.link = link;
          this.status = status;
        }
    }
 });


</script>

<?php require APP_ROOT . '/views/includes/footer.php'; ?>