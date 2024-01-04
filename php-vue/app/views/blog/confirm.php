<?php require APP_ROOT . '/views/includes/head.php'; ?>

  <form action="<?php echo URL_ROOT; ?>/blog/complete" method="post">
    <div class="preview-bar">
      <h3 class="white-text">◯◯ ブログ <?php echo $data['slug']; ?>　プレビュー</h3>
      <input type="submit" value="登録" class="red lighten-1 white-text btn" />
    </div>
  </form>

<?php require APP_ROOT . '/views/includes/header.php'; ?>

<article class="post type-post status-publish format-standard hentry category-1">

<?php echo str_replace('../img', URL_MYPAGE . '/img', $data['html']); ?>

<?php require APP_ROOT . '/views/includes/archive.php'; ?>

<?php require APP_ROOT . '/views/includes/footer_nav.php'; ?>

<?php require APP_ROOT . '/views/includes/footer.php'; ?>