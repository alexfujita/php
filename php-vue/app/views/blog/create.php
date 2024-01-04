<?php require APP_ROOT . '/views/includes/head.php'; ?>
<div class="container">
    <div class="row flex-column">
        <form action="<?php echo URL_ROOT; ?>/blog/confirm" method="post">
            <div class="subheader">
                <h3>◯◯　ブログ　登録</h3>
                <input type="submit" value="確認" class="btn btn-success">
            </div>
            <div class="form-group">
                <label for="slug">ブログ　ページスラッグ: <sup>*</sup></label>
                <input type="text" name="slug" class="form-control form-control-lg <?php echo (!empty($data['slug_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['slug']; ?>" placeholder="例：2020-06-29">
                <span class="invalid-feedback"><?php echo $data['slug_err']; ?></span>
            </div>
            <div class="form-group">
                <label for="html">Html: <sup>*</sup></label>
                <textarea name="html" class="form-control <?php echo (!empty($data['html_err'])) ? 'is-invalid' : ''; ?>"><?php echo $data['html']; ?></textarea>
                <span class="invalid-feedback"><?php echo $data['html_err']; ?></span>
            </div>
        </form>
    </div>
</div>
<?php require APP_ROOT . '/views/includes/footer.php'; ?>