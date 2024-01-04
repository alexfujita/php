<?php require APP_ROOT . '/views/includes/head.php'; ?>
<div class="container">
  <div class="row flex-column">
<div id="app">
    <div v-cloak>
    <div class="subheader" style="width: 100%">
        <h3>◯◯ | お知らせ管理画面</h3>
        <a href="<?php echo URL_ROOT; ?>/news/create" class="waves-effect waves-light btn"><i class="material-icons left">add_box</i>新規</a>
    </div>
    <table class="striped">
        <thead>
            <tr>
                <th class="align-center">公開日</th>
                <th class="align-center">内容</th>
                <th class="align-center">編集</th>
                <th class="align-center">削除</th>
                <th class="align-center">ステータス</th>
            </tr>
        </thead>
        <tbody id="newsInfo">
            <tr v-for='n in news' class="align-center">
                <td>{{n.published}}</td>
                <td>{{n.item}}</td>
                <td class="align-center"><a :href="`<?php echo URL_ROOT; ?>/news/edit/${n.id}`"><i class="material-icons">edit</i></a></td>
                <td class="align-center" id="show-modal" @click="removeNewsModal(n.id, n.item)">
                    <i class="material-icons red-text">delete_forever</i>
                </td>
                <td class="align-center">
                    <div class="switch">
                        <label>
                            <input type="checkbox" v-model="n.status == 1 ? true : false" :value="n.status" @change="handleChangeActive($event, n.id)">
                            <span class="lever"></span><span v-if="n.status === '1'" class="teal-text lighten-5">表示</span>
                            <span v-else>非表示</span>
                        </label>
                    </div>
                </td>

            </tr>
        </tbody>
    </table>

    <!-- use the modal component, pass in the prop -->
    <div v-if="showModal" class="modal-background grey lighten-4" @close="showModal = false">
        <div class="modal-container">
            <div class="modal-content">
            <h5>本当に削除してよろしいでしょうか？</h5>
            <p>◯◯ お知らせ {{n.item}}</p>
            </div>
            <div class="modal-footer">
                <a class="waves-effect waves-light btn-large grey darken-1" style="margin-right: 20px;" @click="showModal = false">キャンセル</a>
                <a class="waves-effect waves-light btn-large red darken-1" style="margin-left: 20px;" @click="handleDeleteNews(n.id)"><i class="material-icons left" style="margin-right: 5px;">delete_forever</i>削除</a>
            </div>
        </div>
    </div>
    </div>
</div>
</div>
</div>
<script text="text/babel">
 const app = new Vue({
     el: "#app",
     data: {
        n: {},
        news: [],
        showModal: false
     },
     created: function(){
        this.allNews()
     },
     methods: {
        allNews: function(){
            axios.get('<?php echo URL_ROOT; ?>/api/news')
            .then(function (response) {
                app.news = response.data.news;
            })
            .catch(function (error) {
                console.log(error);
            });
        },
        handleChangeActive: function(e, id){
            const checked = event.target.checked;
            const status = checked == true ? '1' : '0';
            axios.post('<?php echo URL_ROOT; ?>/api/news', {
                id,
                status,
                type: 'status'
            })
            .then(function(response){
                const index = app.news.findIndex(n => n.id === response.data.id);
                app.news[index].status = response.data.status;
            })
            .catch(function(error){
                console.error(error)
            });
        },
        removeNewsModal: function(id, slug){
            this.showModal = true;
            this.n = {id: id, slug: slug}
        },
        handleDeleteNews: function(id){
            axios.post('<?php echo URL_ROOT; ?>/api/news', {
                id,
                type: 'delete'
            })
            .then(function(response){
                app.showModal = false;
                console.log(response);
                axios.get('<?php echo URL_ROOT; ?>/api/news')
                .then(function (response) {
                    app.news = response.data.news;
                })
                .catch(function (error) {
                    console.log(error);
                });
            })
            .catch(function(error){
                console.error(error);
            })
        }

     }
 });

</script>

<?php require APP_ROOT . '/views/includes/footer.php'; ?>