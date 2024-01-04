<?php require APP_ROOT . '/views/includes/admin/header.php'; ?>
<div id="app">
<div class="container">
<form>
    <fieldset>
        <div class="row mx-1">
            <div class="column">
            <input @change="handleImages" type="file" ref="file" multiple="multiple" name="file" id="file" class="inputfile" accept="image/*" />
            <label for="file">Choose a file</label>
            </div>
        </div>  

        <div v-for="image in imagespreview">
            <img :src="image" alt="">

        </div>

    </fieldset>
</form>
</div>
</div>
<script text="text/babel">
const app = new Vue({
  el: '#app',
  data() {
      return {
          imagespreview: [],
          images: []
      }
  },
  methods: {
      handleImages(e) {
        const FileList = e.target.files;
        const files = Array.from(FileList);

        files.map((file) => {
            this.imagespreview = [...this.imagespreview, URL.createObjectURL(file)];
            this.images = [...this.images, file];
        })

        console.info('images', this.images);
      },
      submitPhotos() {
          this.images.map((img) => {
            new Promise(function (resolve, reject) {
                const reader = new FileReader();
                reader.onerror = reject;
                reader.onload = function (e) {
                    return resolve(e.target.result);
                };
                reader.readAsDataURL(file);
            }).then((result) => {
                axios.post('fileupload', result, {

                }).then(function(){
                }).catch(function(){
                });
            })
          })

      }
      
  }
})
</script>