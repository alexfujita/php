<?php require APP_ROOT . '/views/includes/head.php'; ?>
<div class="container">
  <div class="row flex-column">
<div id="app">
    <div v-cloak>
    <div class="subheader" style="width: 100%">
        <h3>◯◯ | ポテトブログ管理画面</h3>
        <a href="<?php echo URL_ROOT; ?>/potatoblog/create" class="waves-effect waves-light btn"><i class="material-icons left">add_box</i>新規</a>
    </div>
    <table class="striped">
        <thead>
            <tr>
                <th>タイトル</th>
                <th class="align-center">表示</th>
                <th class="align-center">編集</th>
                <th class="align-center">削除</th>
                <th class="align-center">ステータス</th>
            </tr>
        </thead>
        <tbody id="blogs">

            <tr v-for='(blog, r) in blogs' class="align-center">
                <td>◯◯ ミーティング用アンケート{{blog.slug}}</td>
                <td class="align-center"><a :href="`<?php echo URL_ROOT; ?>/potatoblog/${blog.slug}`"><i class="material-icons blue-grey-text lighten-4">remove_red_eye</i></a></td>
                <td class="align-center"><a :href="`<?php echo URL_ROOT; ?>/potatoblog/edit/${blog.slug}`"><i class="material-icons">edit</i></a></td>
                <td class="align-center" id="show-modal" @click="removeRoomModal(blog.id, blog.slug)">
                    <i class="material-icons red-text">delete_forever</i>
                </td>
                <td class="align-center">
                    <div class="switch">
                        <label>
                            <input type="checkbox" v-model="blog.status == 1 ? true : false" :value="blog.status" @change="handleChangeActive($event, blog.id)">
                            <span class="lever"></span><span v-if="blog.status === '1'" class="teal-text lighten-5">表示</span>
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
            <p>◯◯ ポテトブログ {{blog.slug}}</p>
            </div>
            <div class="modal-footer">
                <a class="waves-effect waves-light btn-large grey darken-1" style="margin-right: 20px;" @click="showModal = false">キャンセル</a>
                <a class="waves-effect waves-light btn-large red darken-1" style="margin-left: 20px;" @click="handleDeleteRoom(blog.id)"><i class="material-icons left" style="margin-right: 5px;">delete_forever</i>削除</a>
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
        blog: {},
        blogs: [],
        activeBlogs: [],
        showModal: false
     },
     created: function(){
        this.allBlogs()
     },
     methods: {
        allBlogs: function(){
            axios.get('<?php echo URL_ROOT; ?>/api/blogs')
            .then(function (response) {
                app.blogs = response.data.blogs;
            })
            .catch(function (error) {
                console.log(error);
            });
        },
        handleChangeActive: function(e, id){
            const checked = event.target.checked;
            const status = checked == true ? '1' : '0';
            axios.post('<?php echo URL_ROOT; ?>/api/blogs', {
                id,
                status,
                type: 'status'
            })
            .then(function(response){
                const index = app.blogs.findIndex(blog => blog.id === response.data.id);
                app.blogs[index].status = response.data.status;
            })
            .catch(function(error){
                console.error(error)
            });
        },
        removeRoomModal: function(id, slug){
            console.log(id);
            this.showModal = true;
            this.blog = {id: id, slug: slug}
        },
        handleDeleteRoom: function(id){
            axios.post('<?php echo URL_ROOT; ?>/api/blogs', {
                id,
                type: 'delete'
            })
            .then(function(response){
                app.showModal = false;
                console.log(response);
                axios.get('<?php echo URL_ROOT; ?>/api/blogs')
                .then(function (response) {
                    app.blogs = response.data.blogs;
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