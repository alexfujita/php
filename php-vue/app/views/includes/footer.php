        <script src="<?php echo URL_ROOT; ?>/scripts/script.js"></script>
        <script src="https://cdn.tiny.cloud/1/xxx/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
        <script>
            tinymce.init({
            selector: "textarea",
            language: "ja",
            plugins: "code autolink lists media table",
            toolbar: "addcomment showcomments casechange table code",
            toolbar_mode: "floating",
            tinycomments_mode: "embedded",
            tinycomments_author: "Author name",
            extended_valid_elements : 'span',
            valid_children : 'h1[div],h2[div],h3[div]',
            height: 600
            });
        </script>

    </body>
</html>