<?php require APP_ROOT . '/views/includes/head.php'; ?>


<?php require APP_ROOT . '/views/includes/header.php'; ?>

<?php echo str_replace('../../img', URL_MYPAGE . '/img', $data['room']->html); ?>

<?php require APP_ROOT . '/views/includes/archive.php'; ?>


<?php require APP_ROOT . '/views/includes/footer_nav.php'; ?>

<?php require APP_ROOT . '/views/includes/footer.php'; ?>