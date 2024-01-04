<!DOCTYPE html>
<html lang="ja" style="overflow: hidden">
<head>
  <meta charset="utf-8">
  <title><?php echo SITE_NAME;?></title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
  <link href="<?php echo URL_ROOT; ?>/css/normalize.css" rel="stylesheet" media="screen">
  <link href="<?php echo URL_ROOT; ?>/css/style.css" rel="stylesheet" media="screen">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Crimson+Text:wght@400;600;700&display=swap" rel="stylesheet">

  <?php if (isset($data['page']) && $data['page'] === 'work') : ?>
  <link href="<?php echo URL_ROOT; ?>/css/tooltipster.bundle.min.css" rel="stylesheet" media="screen">
  <link href="<?php echo URL_ROOT; ?>/css/tooltipster.bundle.min.css" rel="stylesheet" media="screen">
  <link href="<?php echo URL_ROOT; ?>/css/pinchzoomer.min.css" rel="stylesheet" media="screen">
  <link href="<?php echo URL_ROOT; ?>/css/masonry.css" rel="stylesheet" media="screen">
  <link href="<?php echo URL_ROOT; ?>/css/masonry_example.min.css rel="stylesheet" media="screen">

  <?php else : ?>
  <script src="<?php echo URL_ROOT; ?>/js/jquery.min.js"></script>
  <?php endif; ?>

  <!-- meta -->
  <meta name="description" content="">
  <meta name="keywords" content="">
</head>

<body style="overflow: auto">
<?php if (isset($data['page']) && $data['page'] === 'top') : ?>
<script>
var showIntro = false;
if (localStorage.getItem('futurity') === null) {
  showIntro = true;
  localStorage.setItem('futurity', 'intro');
}

jQuery.fn.visible = function() {
  return this.css('visibility', 'visible');
};

jQuery.fn.invisible = function() {
  return this.css('visibility', 'hidden');
};

jQuery.fn.opacity = function() {
  return this.css('opacity', '0').fadeTo(5000, 1);
};

var html = 
  '<div class="container--intro">' + 
      '<div class="symbol">' + 
        '<svg xmlns="http://www.w3.org/2000/svg" width="80" height="97" viewBox="0 0 80 97"><path d="M339.455,728.073a19.55,19.55,0,0,0-14.869,7.09v-7.09H307.516v1.476h8.063v24.505a21.977,21.977,0,0,1-1.361,7.915,22.383,22.383,0,0,1-3.4,6.061,15.534,15.534,0,0,1-4.5,3.9,9.8,9.8,0,0,1-4.764,1.37,8.488,8.488,0,0,1-4.4-1,7.832,7.832,0,0,1-2.723-2.741,11.149,11.149,0,0,1-1.413-4.06,32.245,32.245,0,0,1-.367-5.06V729.549h8.064v-1.476h-8.064v-5.588c0-5.163-.749-12.568,1.333-17.713,2.228-5.507,6.26-6.835,9.874-6.835,6.32,0,11.517,3.368,11.517,8.206h1.466c0-4.258-4.159-9.8-12.983-9.8-11.206,0-20.21,9.262-20.21,26.146v5.588h-8.065v1.476h8.063v29.942c0,.028,0,.056,0,.084v7.617c0,5.163.749,12.568-1.332,17.712-2.229,5.508-6.26,6.835-9.875,6.835-6.32,0-11.517-3.367-11.517-8.2h-1.466c0,4.258,4.16,9.8,12.983,9.8,9.693,0,17.726-6.942,19.722-19.741.2.077.383.155.592.231a20.361,20.361,0,0,0,6.807.947,15.09,15.09,0,0,0,6.022-1.106,16.445,16.445,0,0,0,4.5-2.847,17.184,17.184,0,0,0,3.247-3.9,38.832,38.832,0,0,0,2.249-4.266V773.3H332.65v-1.477h-8.063V758.393c0-15.043,2.219-25.573,10.462-28.19.271-.083.547-.159.827-.226s.554-.121.838-.171.588-.107.89-.141a15.99,15.99,0,0,1,1.851-.116Z" transform="translate(-259.455 -696.339)" fill="#fff"/></svg>' +
      '</div>' +
    
      '<div class="container--outer">'+
        '<div class="container" id="top">'+
          '<nav>'+
            '<div class="flex align-center space-between" style="visibility: hidden;">'+
              '<a href="#" class="inherit">'+
                '<svg id="logo" xmlns="http://www.w3.org/2000/svg" width="159.773" height="43.039" viewBox="0 0 159.773 43.039">'+
                  '<path d="M469.332,249h-7.184v.655h3.9L459.682,264.4l-6.08-14.745h3.944V249H439v-6.611h-4.039V249H417.027a8.8,8.8,0,0,0-6.666,3.146V249h-7.654v.655h3.615v18.758H396.041V249.641h3.615v-.655h-3.615V249h-7.606v.655H392V260.51a9.68,9.68,0,0,1-.611,3.532,9.927,9.927,0,0,1-1.526,2.69,6.943,6.943,0,0,1-2.019,1.731,4.42,4.42,0,0,1-2.136.608,3.838,3.838,0,0,1-1.972-.444,3.49,3.49,0,0,1-1.221-1.217,4.906,4.906,0,0,1-.634-1.8,14.163,14.163,0,0,1-.164-2.245V249H367.4v-6.611h-4.038V249H345.475v.655h3.569V260.51a9.68,9.68,0,0,1-.611,3.532,9.939,9.939,0,0,1-1.526,2.69,6.942,6.942,0,0,1-2.019,1.731,4.422,4.422,0,0,1-2.136.608,3.838,3.838,0,0,1-1.972-.444,3.491,3.491,0,0,1-1.221-1.217,4.915,4.915,0,0,1-.634-1.8,14.159,14.159,0,0,1-.164-2.245V249h-14.32v-2.479h0c0-2.291-.336-5.576.6-7.859a4.451,4.451,0,0,1,4.427-3.033c2.834,0,5.164,1.495,5.164,3.641h.658c0-1.889-1.866-4.35-5.821-4.35-5.024,0-9.061,4.109-9.061,11.6V249h-3.615v.655H320.4v16.7c0,2.291.336,5.576-.6,7.859a4.45,4.45,0,0,1-4.427,3.033c-2.834,0-5.164-1.494-5.164-3.641h-.658c0,1.889,1.865,4.351,5.821,4.351,5.024,0,9.061-4.11,9.061-11.6v-16.7h10.282v13.285a10.06,10.06,0,0,0,.235,2.362,6.644,6.644,0,0,0,.563,1.567,3.435,3.435,0,0,0,.728.959,9.108,9.108,0,0,0,.727.585,7.7,7.7,0,0,0,1.832.889,9.217,9.217,0,0,0,3.052.421,6.845,6.845,0,0,0,2.7-.491,7.4,7.4,0,0,0,2.019-1.263,7.666,7.666,0,0,0,1.455-1.731,17.132,17.132,0,0,0,1.01-1.895h.094v4.725H356.7v-.655h-3.616V249.658h10.282v14.875a5.122,5.122,0,0,0,1.385,3.836q1.384,1.357,4.906,1.357a5.479,5.479,0,0,0,2.347-.445,4.585,4.585,0,0,0,1.527-1.122,4.736,4.736,0,0,0,.868-1.427,10.726,10.726,0,0,0,.423-1.356H374.1a5.759,5.759,0,0,1-1.233,2.5,3.307,3.307,0,0,1-2.653,1.193,3.505,3.505,0,0,1-.962-.141,2.03,2.03,0,0,1-.915-.584,3.206,3.206,0,0,1-.681-1.263,7.253,7.253,0,0,1-.258-2.129v-15.3h10.282v13.285a10.09,10.09,0,0,0,.234,2.362,6.641,6.641,0,0,0,.564,1.567,3.443,3.443,0,0,0,.728.959,9.2,9.2,0,0,0,.728.585,7.7,7.7,0,0,0,1.831.889,9.216,9.216,0,0,0,3.052.421,6.847,6.847,0,0,0,2.7-.491,7.4,7.4,0,0,0,2.019-1.263,7.679,7.679,0,0,0,1.455-1.731,17.132,17.132,0,0,0,1.01-1.895h.094v4.725h22.348v-.655h-4.085v-5.96c0-6.674,1-11.346,4.69-12.508.122-.037.245-.071.372-.1s.247-.053.375-.075.263-.047.4-.063a7.484,7.484,0,0,1,.83-.051h3.615v18.758h-3.615v.655H428.3v-.655H424.68V249.658h10.282v14.875a5.122,5.122,0,0,0,1.385,3.836q1.385,1.357,4.906,1.357a5.482,5.482,0,0,0,2.348-.445,4.585,4.585,0,0,0,1.527-1.122,4.75,4.75,0,0,0,.868-1.427,10.787,10.787,0,0,0,.422-1.356H445.7a5.769,5.769,0,0,1-1.232,2.5,3.308,3.308,0,0,1-2.653,1.193,3.5,3.5,0,0,1-.962-.141,2.031,2.031,0,0,1-.916-.585,3.211,3.211,0,0,1-.681-1.263,7.268,7.268,0,0,1-.257-2.129v-15.3h10.282l8.123,20.02-1.3,3.018c-.993,2.3-2.191,4.551-4.914,4.551-2.164,0-3.509-1.106-3.509-2.887h-.717c0,2.106,1.57,3.6,4.225,3.6,3.362,0,4.691-2.94,5.573-4.983l10.064-23.32h2.506V249Z" transform="translate(-309.559 -234.923)" />'+
                '</svg>'+
              '</a>'+
              '<ul class="flex flex-end fs-16">'+
                '<li><a href="/works">WORKS</a></li>'+
                '<li><a href="/profile">PROFILE</a></li>'+
                '<li><a href="/news">NEWS</a></li>'+
                '<li><a href="/recruit">RECRUIT</a></li>'+
                '<li><a href="/contact">CONTACT</a></li>'+
              '</ul>'+
            '</div>'+
          '</nav>'+
          '<div class="container--inner top--message-intro" id="top--text">' +
            '<div class="top--message-intro-en-container">' +
                  '<picture>' +
                    '<source media="(max-width: 767px)" srcset="<?php echo URL_ROOT; ?>/img/message-smp-en-intro.png">' +
                    '<source media="(max-width: 1023px)" srcset="<?php echo URL_ROOT; ?>/img/message-tablet-en-intro.png">' +
                    '<source media="(min-width: 1024px)" srcset="<?php echo URL_ROOT; ?>/img/message-en-intro.png">' +
                    '<img src="<?php echo URL_ROOT; ?>/img/message-en-intro.png" alt="">' +
                  '</picture>' +
              '</div>' +
              '<div class="top--message-intro-ja-container">' +
                  '<picture>' +
                    '<source media="(max-width: 767px)" srcset="<?php echo URL_ROOT; ?>/img/message-smp-ja-intro.png">' +
                    '<source media="(max-width: 1023px)" srcset="<?php echo URL_ROOT; ?>/img/message-tablet-ja-intro.png">' +
                    '<source media="(min-width: 1024px)" srcset="<?php echo URL_ROOT; ?>/img/message-ja-intro.png">' +
                    '<img src="<?php echo URL_ROOT; ?>/img/message-ja-intro.png" alt="">' +
                  '</picture>' +
              '</div>' +
          '</div>'+
          '<div class="footer">'+
            '<p class="m-0">©2021 FUTURITY inc.</p>'+
          '</div>'+
        '</div>'+
      '</div>'+

    '</div>'+

  '</body>'+
'</html>';
if (showIntro) {
  $('body').append(html);
  $('.symbol').hide().delay(1500).fadeIn(3000).fadeOut(2000);
  $('.top--message-intro-ja-container').hide().visible().delay(6000).fadeIn(2000);
  $('.top--message-intro-en-container').delay(8000).opacity();
  $('.container--intro').delay(11000).fadeOut(2000);
}
</script>
<?php endif; ?>

<div class="container--outer">
  <div class="container" <?php echo isset($data['page']) ? 'id="' . $data['page'] . '" ' : null; ?>>
  <?php require APP_ROOT . '/views/includes/navbar.php'; ?>
