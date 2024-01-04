<?php require APP_ROOT . '/views/includes/head.php'; ?>

<?php if(isset($data['confirm'])) : ?>
  <form action="<?php echo URL_ROOT; ?>/mtgroom/complete" method="post">
    <div class="preview-bar">
      <h3 class="white-text">◯◯ ミーティング用アンケート<?php echo $data['slug']; ?>　プレビュー</h3>
      <input type="submit" value="登録" class="red lighten-1 white-text btn" />
    </div>
  </form>
<?php require APP_ROOT . '/views/includes/header.php'; ?>
<?php endif; ?>

<?php echo str_replace('../../img', URL_MYPAGE . '/img', $data['html']); ?>

<?php require APP_ROOT . '/views/includes/archive.php'; ?>

<?php require APP_ROOT . '/views/includes/footer_nav.php'; ?>

<?php require APP_ROOT . '/views/includes/footer.php'; ?>