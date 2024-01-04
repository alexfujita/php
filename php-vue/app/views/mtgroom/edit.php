<?php require APP_ROOT . '/views/includes/head.php'; ?>
<div class="container">
    <div class="row flex-column">
        <form action="<?php echo URL_ROOT; ?>/mtgroom/confirm" method="POST">
            <div class="subheader">
                <h3>◯◯　ミーティングルーム　編集</h3>
                <input type="submit" value="確認" class="btn btn-success">
            </div>
            <div class="form-group">
                <label for="slug">スラッグ</label>
                <input type="text" class="form-control" id="slug" name="slug" value="<?php echo $data['room']->slug; ?>" />
            </div>
            <div class="form-group">
                <label for="html">Html</label>
                <textarea class="form-control" name="html" id="html" rows="3"><?php echo str_replace('../../img', URL_MYPAGE . '/img', $data['room']->html); ?></textarea>
            </div>
            <input type="hidden" name="id" value="<?php echo $data['room']->id; ?>"/>
        </form>
    </div>
</div> 
<?php require APP_ROOT . '/views/includes/footer.php'; ?>