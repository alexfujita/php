<?php require APP_ROOT . '/views/includes/admin/header.php'; ?>
<div id="app">
<div class="container">
<form>
<fieldset>
    <div class="row mx-1">
        <div class="column column-20">
            <label for="nameField">日付</label>
            <vuejs-datepicker v-model="date" format="yyyy-MM-dd"></vuejs-datepicker>
        </div>
    </div>

    <div class="row mx-1">
        <div class="column">
            <label for="nameField">タイトル</label>
            <input type="text" placeholder="" id="title" name="title" value="">
        </div>
    </div>

    <div class="row mx-1">
        <div class="column">
            <label for="nameField">内容</label>
            <textarea placeholder="" id="body" name="body" class="row-5"></textarea>
        </div>
    </div>

    <div class="row mx-1">
        <div class="column">
            <img :src="preview" alt="">
            <input @change="handleImage" type="file" name="file" id="file" class="inputfile" accept="image/*" />
            <label v-if="!preview" for="file">Choose a file</label>
        </div>
    </div>

</fieldset>
</form>
</div>
</div>
<script src="https://unpkg.com/vuejs-datepicker"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-xxx" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
const date = moment().format('YYYY-MM-DD');
const app = new Vue({
  el: '#app',
  data() {
    return {
      date: date,
      preview: '',
      image: ''
    }
  },
  methods: {
    handleImage(e) {
          const file = e.target.files[0];
          this.preview = URL.createObjectURL(file)
      }
  },
  components: {
  	vuejsDatepicker
  }
})
</script>
<?php require APP_ROOT . '/views/includes/footer.php'; ?>