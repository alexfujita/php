<?php require APP_ROOT . '/views/includes/head.php'; ?>
<div id="app">
<div class="container">
    <div class="row form">
            <div class="subheader">
                <h3>◯◯　プロフィール画像　編集</h3>
            </div>

            <div class="row">
                <div v-if="!image" class="input-field col s12">
                    <div class="file-field input-field">
                        <div class="btn">
                            <span>プロフィール画像</span>
                            <input type="file" @change="onFileChange" accept="image/*">
                        </div>

                        <div class="file-path-wrapper">
                            <input class="file-path validate" style="border: none;" type="text">
                        </div>
                    </div>
                    <label><span>幅：120px 高：153px　／　ファイル形式：png</span></label>

                </div>
                <div v-else class="image-preview-wrapper">
                    <img :src="image" class="image-preview">
                    <a class="waves-effect red lighten-1 btn"　@click="removeImage"><i class="material-icons left">delete</i>画像削除</a>
                </div>
            </div>

            <div class="row">
                <div class="input-field col s6">
                    <input v-model="filename" id="filename" placeholder="例：usushio" />
                    <label for="filename">ファイル名（ローマ字）拡張子無</label>
                </div>
            </div>

            <div class="row">
                <div class="switch">
                    <label>
                        <input type="checkbox" v-model="special" @change="onSpecialChange($event)">
                            <span class="lever"></span><span v-bind:class="{ 'teal-text lighten-5' : special === true }">期間限定</span>
                    </label>
                </div>
            </div>

            <div v-if="showDate">
            <div class="row">
                <h6>反映開始日時</h6>
                <div class="col s8">
                    <div class="col s7">
                        <div class="input-field col s4">
                            <select class="browser-default" v-model="start_year">
                                <option v-for="year in start_years" v-bind:value="year.value">{{ year.text }}</option>
                            </select>
                        </div>
                        
                        <div class="input-field col s4">
                            <select class="browser-default" v-model="start_month">
                                <option v-for="month in start_months" v-bind:value="month.value">{{ month.text }}</option>
                            </select>
                        </div>
                        
                        <div class="input-field col s4">
                            <select class="browser-default" v-model="start_day">
                                <option v-for="day in start_days" v-bind:value="day.value">{{ day.text }}</option>
                            </select>
                        </div>
                        
                    </div>

                    <div class="col s5">
                        <div class="input-field col s6">
                            <select class="browser-default" v-model="start_hour">
                                <option v-for="hour in start_hours" v-bind:value="hour.value">{{ hour.text }}</option>
                            </select>
                        </div>
                        <div class="input-field col s6">
                            <select class="browser-default" v-model="start_minute">
                                <option v-for="minute in start_minutes" v-bind:value="minute.value">{{ minute.text }}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row teal-text lighten-5">
                <span v-if="start_year">{{start_year}}年</span>
                <span v-if="start_month">{{start_month}}月</span>
                <span v-if="start_day">{{start_day}}日</span>
                <span v-if="start_hour">{{start_hour}}時</span>
                <span v-if="start_minute">{{start_minute}}分</span>
            </div>

            <div class="row">
                <h6>反映終了日時</h6>
                <div class="col s8">
                    <div class="col s7">
                        <div class="input-field col s4">
                            <select class="browser-default" v-model="end_year">
                                <option v-for="year in end_years" v-bind:value="year.value">{{ year.text }}</option>
                            </select>
                        </div>
                        
                        <div class="input-field col s4">
                            <select class="browser-default" v-model="end_month">
                                <option v-for="month in end_months" v-bind:value="month.value">{{ month.text }}</option>
                            </select>
                        </div>
                        
                        <div class="input-field col s4">
                            <select class="browser-default" v-model="end_day">
                                <option v-for="day in end_days" v-bind:value="day.value">{{ day.text }}</option>
                            </select>
                        </div>
                        
                    </div>

                    <div class="col s5">
                        <div class="input-field col s6">
                            <select class="browser-default" v-model="end_hour">
                                <option v-for="hour in end_hours" v-bind:value="hour.value">{{ hour.text }}</option>
                            </select>
                        </div>
                        <div class="input-field col s6">
                            <select class="browser-default" v-model="end_minute">
                                <option v-for="minute in end_minutes" v-bind:value="minute.value">{{ minute.text }}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row teal-text lighten-5">
                <span v-if="end_year">{{end_year}}年</span>
                <span v-if="end_month">{{end_month}}月</span>
                <span v-if="end_day">{{end_day}}日</span>
                <span v-if="end_hour">{{end_hour}}時</span>
                <span v-if="end_minute">{{end_minute}}分</span>
            </div>

            </div>

            <div class="row">
                <div class="switch">
                    <label>
                        <input type="checkbox" v-model="status">
                        <span class="lever"></span><span v-bind:class="{ 'teal-text lighten-5' : status === true }">表示</span>
                    </label>
                </div>
            </div>

            <div class="row btn-fluid">
                <div class="col s8">
                    <a class="waves-effect waves-light btn-large" @click="addBag">
                        更新する
                    </a>
                </div>
            </div>
    </div>
</div>
</div>

<script src="<?php echo URL_ROOT; ?>/scripts/constants.js"></script>

<script text="text/babel">


 const app = new Vue({
     el: "#app",
     data: {
        id: null,
        image: null,
        beforeFilename: null,
        filename: null,
        special: false,
        showDate: false,
        status: false,
        start_year: '',
        start_years: years,
        start_month: '',
        start_months: months,
        start_day: '',
        start_days: days,
        start_hour: '',
        start_hours: hours,
        start_minute: '',
        start_minutes: minutes,
        end_year: '',
        end_years: years,
        end_month: '',
        end_months: months,
        end_day: '',
        end_days: days,
        end_hour: '',
        end_hours: hours,
        end_minute: '',
        end_minutes: minutes
     },
     created: function(){
        this.getBag()
     },
     methods: {
         getBag: function(){
            const id = <?php echo $data['bag']->id; ?>;
            const img = '<?php echo $data['bag']->img; ?>';
            const status = <?php echo $data['bag']->status; ?>;
            const special = <?php echo $data['bag']->special; ?>;
            let start;
            let end;
            if(start !== ''){
                start = '<?php echo $data['bag']->start; ?>';
                const start_year = start.substring(0, 4);
                const start_month = start.substring(5, 7);
                const start_day = start.substring(8, 10);
                const start_hour = start.substring(11, 13);
                const start_minute = start.substring(14, 16);
                this.start_year = start_year;
                this.start_month =start_month;
                this.start_day = start_day;
                this.start_hour = start_hour;
                this.start_minute = start_minute;
            }
            if(end !== ''){
                end = '<?php echo $data['bag']->end; ?>';
                const end_year = end.substring(0, 4);
                const end_month = end.substring(5, 7);
                const end_day = end.substring(8, 10);
                const end_hour = end.substring(11, 13);
                const end_minute = end.substring(14, 16);
                this.end_year = end_year;
                this.end_month = end_month;
                this.end_day = end_day;
                this.end_hour = end_hour;
                this.end_minute = end_minute;
            }

            if(special == 1){
                this.showDate = true;
            }

            this.id = id;
            this.image = '<?php echo URL_MYPAGE; ?>/img/bag/'+img;
            this.beforeFilename =img.substring(0, img.length - 4);
            this.filename = img.substring(0, img.length - 4);
            this.status = status == 1 ? true : false;
            this.special = special == 1 ? true : false;

         },
        onFileChange(e){
            const files = e.target.files || e.dataTransfer.files;
            if (!files.length){
                return;
            }
            this.createImage(files[0]);
        },
        createImage(file){
            const image = new Image();
            const reader = new FileReader();

            reader.onload = (e) => {
                this.image = e.target.result;
            };
            reader.readAsDataURL(file);
        },
        removeImage(){
            this.image = '';
        },
        onSpecialChange(e){
            const checked = e.target.checked;
            console.log(checked);
            if(checked){
                app.showDate = true;
            } else {
                app.showDate = false;
                app.start_year = '';
                app.start_month = '';
                app.start_day = '';
                app.start_hour = '';
                app.start_minute = '';
                app.end_year = '';
                app.end_month = '';
                app.end_day = '';
                app.end_hour = '';
                app.end_minute = '';                
            }
        },
        addBag(){

            const data = {
                id: app.id,
                beforeFilename : app.beforeFilename,
                filename: app.filename,
                status: app.status,
                special: app.special
            };

            const isImageData = app.image.match(/^(?:[data]{4}:(text|image|application)\/[a-z]*)/);

            if(isImageData){
                const dataBase64encoded = app.image;
                const arr = dataBase64encoded.split(";");
                const extension = arr[0].split("/")[1];
                const base64encode = arr[1].replace(/base64,/, "");
                data.image = base64encode;
            }

            if(app.special){
                const start = `${app.start_year}-${app.start_month}-${app.start_day} ${app.start_hour}:${app.start_minute}:00`;
                data.start = start;

                const end = `${app.end_year}-${app.end_month}-${app.end_day} ${app.end_hour}:${app.end_minute}:00`;
                data.end = end;

            }

            axios.post('<?php echo URL_ROOT; ?>/api/bag', {
                data
            })
            .then(function(response){
                console.log(response);
                if (response['data']['code'] === "200") {
                    window.location.href = '<?php echo URL_ROOT; ?>/bags/Complete';
                }
            })
            .catch(function(error){
                console.log(error);
            })
        }
     }
 });

</script>

<?php require APP_ROOT . '/views/includes/footer.php'; ?>