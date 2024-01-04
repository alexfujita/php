<!DOCTYPE html>
<html lang="ja" v-bind:class="{ unscrollable: showModal = true }">
<head>
  <meta charset="utf-8">
  <title><?php echo SITE_NAME;?></title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
  <link href="<?php echo URL_ROOT; ?>/css/style.css" rel="stylesheet" media="screen">
  <link href="<?php echo URL_ROOT; ?>/css/admin.css" rel="stylesheet" media="screen">
  <link href="<?php echo URL_ROOT; ?>/css/milligram.min.css" rel="stylesheet" media="screen">
  <link href="<?php echo URL_ROOT; ?>/css/icofont.min.css" rel="stylesheet" media="screen">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-standalone/6.7.7/babel.min.js"></script>
  <script src="<?php echo URL_VUE; ?>"></script>
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <meta name="description" content="">
  <meta name="keywords" content="">
</head>

<body>
  <?php require APP_ROOT . '/views/includes/admin/navbar.php'; ?>
