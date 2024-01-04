<?php require APP_ROOT . '/views/includes/head.php'; ?>


<?php require APP_ROOT . '/views/includes/header.php'; ?>
<article class="post type-post status-publish format-standard hentry category-1">

<?php echo str_replace('../img', URL_MYPAGE . '/img', $data['blog']->html); ?>


<?php require APP_ROOT . '/views/includes/footer_nav.php'; ?>

<?php require APP_ROOT . '/views/includes/footer.php'; ?>