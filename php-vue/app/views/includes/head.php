<!DOCTYPE html>
<html lang="ja" v-bind:class="{ unscrollable: showModal = true }">
<head>
  <meta charset="utf-8">
  <title><?php echo SITE_NAME;?></title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

  <?php if( isset($data['page']) && ( $data['page'] == 'show' || $data['page'] == 'confirm' || $data['page'] == 'points' )  ) : ?>
  <link href="<?php echo URL_MYPAGE; ?>/css/bootstrap.min.css" rel="stylesheet" media="screen">
  <?php endif; ?>
  <link href="<?php echo URL_MYPAGE; ?>/css/style.css" rel="stylesheet" media="screen">
  <?php if(isset($data['blog'])) : ?>
  <link href="<?php echo URL_MYPAGE; ?>/css/blog.css" rel="stylesheet" media="screen">
  <?php endif; ?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="<?php echo URL_ROOT; ?>/styles/admin.css" rel="stylesheet" media="screen">

  <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-standalone/6.7.7/babel.min.js"></script>
  <script src="<?php echo URL_VUE; ?>"></script>
  <script src="<?php echo URL_VUE_DATEPICKER; ?>"></script>
  <script src="<?php echo URL_VUE_DATEPICKER_JA; ?>"></script>
  <script src="<?php echo URL_MOMENT; ?>"></script>
  <script src="<?php echo URL_MOMENT_LOCAL; ?>"></script>
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

  <style>
    .dataTables_processing img {
      max-width: 30px;
    }
  </style>

<!-- meta -->
<meta name="description" content="">
<meta name="keywords" content="">

<!-- ogp -->
</head>

<body class="admin <?php if(isset($data['class']['body'])) echo $data['class']['body']; ?>">


<?php require APP_ROOT . '/views/includes/navbar.php'; ?>
