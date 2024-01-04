<?php require APP_ROOT . '/views/includes/head.php'; ?>
<div class="container">
  <div class="row flex-column">
<div id="app">
    <div v-cloak>
    <div class="subheader" style="width: 100%">
        <h3>◯◯ | プロフィール画像管理画面</h3>
        <a href="<?php echo URL_ROOT; ?>/bags/create" class="waves-effect waves-light btn"><i class="material-icons left">add_box</i>新規</a>
    </div>
    <table class="striped">
        <thead>
            <tr>
                <th>ファイル名</th>
                <th class="align-center">画像</th>
                <th class="align-center">期間限定</th>
                <th class="align-center">販売開始</th>
                <th class="align-center">販売終了</th>
                <th class="align-center">編集</th>
                <th class="align-center">削除</th>
                <th class="align-center">ステータス</th>
                <th class="align-center">並び順</th>
            </tr>
        </thead>
        <tbody id="bags">
            <tr v-for='bag in bags' class="align-center">
                <td style="font-size: 14px;">{{bag.img}}</td>
                <td class="align-center"><img v-bind:src="`<?php echo URL_MYPAGE; ?>/img/bag/${bag.img}`" style="width: 80px;" /></td>
                <td class="align-center">
                    <div class="switch special">
                        <label>
                            <input type="checkbox" v-model="bag.special == 1 ? true : false" :value="bag.special" @change="handleChangeSpecial($event, bag.id)">
                            <span class="lever"></span><span v-if="bag.special === '1'" class="light-blue-text darken-1">限定</span>
                            <span v-else>通常</span>
                        </label>
                    </div>
                </td>
                <td class="align-center">{{bag.start}}</td>
                <td class="align-center">{{bag.end}}</td>
                <td class="align-center"><a :href="`<?php echo URL_ROOT; ?>/bags/edit/${bag.id}`"><i class="material-icons">edit</i></a></td>
                <td class="align-center" id="show-modal" @click="removeBagsModal(bag.id, bag.img)">
                    <i class="material-icons red-text">delete_forever</i>
                </td>
                <td class="align-center">
                    <div class="switch">
                        <label>
                            <input type="checkbox" v-model="bag.status == 1 ? true : false" :value="bag.status" @change="handleChangeActive($event, bag.id)">
                            <span class="lever"></span><span v-if="bag.status === '1'" class="teal-text lighten-5">表示</span>
                            <span v-else>非表示</span>
                        </label>
                    </div>
                </td>
                <td class="align-center">
                    <select class="browser-default" v-model="bag.selected" @change="onSelectChange(bag.id, bag.sort, bag.selected)">
                        <option v-for="sort in bags_ids">{{ sort }}</option>
                    </select>
                </td>
            </tr>
        </tbody>
    </table>
    <!-- use the modal component, pass in the prop -->
    <div v-if="showModal" class="modal-background grey lighten-4" @close="showModal = false">
        <div class="modal-container">
            <div class="modal-content">
                <h5>本当に削除してよろしいでしょうか？</h5>
                <p>◯◯ プロフィール画像 {{bag.img}}</p>
                <div><img v-bind:src="`<?php echo URL_MYPAGE; ?>/img/bag/${bag.img}`" alt="" style="width: 120px;"></div>
            </div>
            <div class="modal-footer">
                <a class="waves-effect waves-light btn-large grey darken-1" style="margin-right: 20px;" @click="showModal = false">キャンセル</a>
                <a class="waves-effect waves-light btn-large red darken-1" style="margin-left: 20px;" @click="handleDeleteBags(bag.id)"><i class="material-icons left" style="margin-right: 5px;">delete_forever</i>削除</a>
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
        bag: {},
        bags: [],
        bags_ids: [],
        showModal: false
     },
     created: function(){
        this.allBags()
     },
     methods: {
        allBags: function(){
            axios.get('<?php echo URL_ROOT; ?>/api/bags')
            .then(function (response) {
                let bags = response.data.bags;
                for (const bag of bags){
                    bag.selected = bag.sort;
                }
                app.bags = bags;
                app.bags_length = bags.length;
                app.bags_ids = [];
                for(let i = 0; i < bags.length; i++){
                    app.bags_ids.push(i+1);
                }

            })
            .catch(function (error) {
                console.log(error);
            });
        },
        onSelectChange: function(id, sort, selected){
            id = parseInt(id);
            sort = parseInt(sort);
            selected = parseInt(selected);
            for (bag of app.bags){
                let bagSort = parseInt(bag.sort);
                let badSelected = parseInt(bag.selected);
                if(bagSort === sort){
                    bag.sort = selected;
                    bag.selected = selected;
                } else {
                    // select number increased
                    if(selected > sort){
                        if(bagSort <= selected && bagSort > sort && bagSort != 1){
                            bag.selected = parseInt(bag.sort) - 1;
                            bag.sort = parseInt(bag.sort) - 1;
                        }
                    // select number decrease    
                    } else if (selected < sort){
                        if(bagSort >= selected && bagSort < sort){
                            bag.selected = parseInt(bag.sort) +1 ;
                            bag.sort = parseInt(bag.sort) + 1;
                        }
                    }
                }
            }
            axios.post('<?php echo URL_ROOT; ?>/api/bagSort', {
                data: app.bags
            })
            .then(function(response){
                if(response.data.code === 200){
                    let bags = response.data.bags;
                    for (const bag of bags){
                        bag.selected = bag.sort;
                    }
                    app.bags = bags;
                    app.bags_length = bags.length;
                    app.bags_ids = [];
                    for(let i = 0; i < bags.length; i++){
                        app.bags_ids.push(i+1);
                    }
                }
            })
            .catch(function(error){
                console.error(error);
            })
        },
        handleChangeSpecial: function(e, id){
            const checked = event.target.checked;
            const special = checked == true ? '1' : '0';
            axios.post('<?php echo URL_ROOT; ?>/api/bags', {
                id,
                special,
                type: 'special'
            })
            .then(function(response){
                const index = app.bags.findIndex(bag => bag.id === response.data.id);
                app.bags[index].special = response.data.special;
            })
            .catch(function(error){
                console.error(error)
            });
        },
        handleChangeActive: function(e, id){
            const checked = event.target.checked;
            const status = checked == true ? '1' : '0';
            axios.post('<?php echo URL_ROOT; ?>/api/bags', {
                id,
                status,
                type: 'status'
            })
            .then(function(response){
                const index = app.bags.findIndex(bag => bag.id === response.data.id);
                app.bags[index].status = response.data.status;
            })
            .catch(function(error){
                console.error(error)
            });
        },
        removeBagsModal: function(id, img){
            this.showModal = true;
            this.bag = {id: id, img: img}
        },
        handleDeleteBags: function(id){
            axios.post('<?php echo URL_ROOT; ?>/api/bags', {
                id,
                type: 'delete'
            })
            .then(function(response){
                app.showModal = false;
                axios.get('<?php echo URL_ROOT; ?>/api/bags')
                .then(function (response) {
                    if(response.data.bags){
                    let bags = response.data.bags;
                    for (const bag of bags){
                        bag.selected = bag.sort;
                    }
                    app.bags = bags;
                    app.bags_length = bags.length;
                    app.bags_ids = [];
                    for(let i = 0; i < bags.length; i++){
                        app.bags_ids.push(i+1);
                    }
                }
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