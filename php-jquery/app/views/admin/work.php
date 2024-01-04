<?php require APP_ROOT . '/views/includes/admin/header.php'; ?>
<div id="app">
<div class="container">
<?php if (!empty($data)) : ?>
<form>
    <fieldset>
    <div class="row mx-1">
        <div class="column">
            <label for="nameField">物件名</label>
            <input type="text" placeholder="" id="property_ja" name="property_ja" value="<?php echo $data['works']->property_ja; ?>">
        </div>
        <div class="column">
            <label for="nameField">Property</label>
            <input type="text" placeholder="" id="property_en" name="property_en" value="<?php echo $data['works']->property_en; ?>">
        </div>
    </div>

    <div class="row mx-1">
        <div class="column">
            <label for="nameField">カテゴリー名</label>
            <select id="category_ja" name="category_ja">
                <option value="<?php echo $data['works']->category_id; ?>" selected="selected"><?php echo $data['works']->category_ja; ?></option>    
                <?php foreach($data['categories'] as $category) : ?>
                <option value="<?php echo $category->id; ?>"><?php echo $category->category_ja; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="column">
            <label for="nameField">場所</label>
                <select id="category_ja" name="category_ja">
                    <option value="<?php echo $data['works']->location_id; ?>" selected="selected"><?php echo $data['works']->location_ja; ?></option>    
                    <?php foreach($data['locations'] as $location) : ?>
                    <option value="<?php echo $location->id; ?>"><?php echo $location->location_ja; ?></option>
                    <?php endforeach; ?>
                </select>
        </div>
    </div>
    <div class="row mx-1">
        <div class="column">
            <label for="nameField">コメント</label>
            <textarea placeholder="" name="description" id="description"><?php echo $data['works']->description; ?></textarea>
        </div>
    </div>

    <div class="row mx-1">
        <div class="column">
            <label for="nameField">年/月</label>
            <input type="text" placeholder="" name="description" id="description" value="<?php echo $data['works']->year; ?>">
        </div>
        <div class="column">
            <label for="nameField">スラッグ</label>
            <input type="text" placeholder="" name="slug" id="slug" value="<?php echo $data['works']->slug; ?>">
        </div>
    </div>

    <div class="row mx-1">
        <div class="column">
        <img :src="image" alt="">
        <input @change="handleImage" type="file" name="file" id="file" class="inputfile" accept="image/*" />
        <label for="file">Choose a file</label>
        </div>
    </div>  
    
    <div class="row mx-1">
        <div class="column">
        <img :src="image" alt="">
        <input @change="handleImage" type="file" name="file" id="file" class="inputfile" accept="image/*" />
        <label for="file">Choose a file</label>
        </div>
    </div>
    
    <?php if ($data['works']) : ?>

    <?php endif; ?>

    <a class="button mt-4" href="#">更新</a>
    </fieldset>
</form>
<?php else : ?>
<h3>Work content not found. </h3>
<p>Please check if ID number in URL is correct</p>
<?php endif; ?>
</div>
</div>
<script text="text/babel">
const app = new Vue({
  el: '#app',
  data() {
      return {
          image: [],
      }
  },
  methods: {
      handleImage(e) {
          const selectedImage = e.target.files;
      },
      createBase64Image(fileObject) {
          const reader = new FileReader();

          reader.onload = (e) => {
              this.image = e.target.result;
          };
          reader.readAsBinaryString(fileObject);

      }
  }
})
</script>
<?php require APP_ROOT . '/views/includes/footer.php'; ?>

