<?php require APP_ROOT . '/views/includes/admin/header.php'; ?>
<div id="app">
<div class="container">

<?php if (!empty($data)) : ?>
<form>
<fieldset>
    <div class="row mx-1">
        <div class="column">
            <label for="nameField">日付</label>
            <vuejs-datepicker v-model="date" format="yyyy-MM-dd" calendar-button="true"></vuejs-datepicker>
            <input type="text" placeholder="" id="date" name="date" value="<?php echo $data->date; ?>">
        </div>
        <div class="column">
            {{date}}
        </div>
    </div>

    <div class="row mx-1">
        <div class="column">
            <label for="nameField">タイトル</label>
            <input type="text" placeholder="" id="title" name="title" value="<?php echo $data->title; ?>">
        </div>
    </div>

    <div class="row mx-1">
        <div class="column">
            <label for="nameField">内容</label>
            <textarea placeholder="" id="body" name="body" class="row-5"><?php echo $data->body; ?></textarea>
        </div>
    </div>

</fieldset>
</form>
<?php else : ?>
<h3>News content not found. </h3>
<p>Please check if ID number in URL is correct</p>
<?php endif; ?>
</div>
</div>
<script src="https://unpkg.com/vuejs-datepicker"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-xxx" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
const date = '<?php echo $data->date; ?>';
const app = new Vue({
  el: '#app',
  data() {
    return {
      date: date
    }
  },
  components: {
  	vuejsDatepicker
  }
})
</script>
<?php require APP_ROOT . '/views/includes/footer.php'; ?>