<?php require APP_ROOT . '/views/includes/header.php'; ?>
<div class="container--inner">
    <h3><?php echo $data['work']->property_en; ?></h3>
    <p class="subtitle">
        <span><?php echo $data['work']->year; ?></span>
        <?php if($data['work']->location_en) : ?>
        <span>/</span>
        <span><?php echo $data['work']->location_en; ?></span>
        <?php endif; ?>

        <?php if($data['work']->category_en) : ?>
        <span>/</span>
        <span><?php echo $data['work']->category_en; ?></span>
        <?php endif; ?>
    </p>
    
    <p class="description ja">
      <?php echo $data['work']->property_ja; ?><br>
      <?php echo $data['work']->description; ?></p>
    <div class="grid"></div>
  </div>
<script src="<?php echo URL_ROOT; ?>/js/jquery-1.11.3.min.js"></script>
<script src="<?php echo URL_ROOT; ?>/js/masonry.min.js"></script> 
<script src="<?php echo URL_ROOT; ?>/js/imagesloaded.min.js"></script> 
<script src="<?php echo URL_ROOT; ?>/js/tooltipster.bundle.min.js"></script>
<script src="<?php echo URL_ROOT; ?>/js/bootstrap.min.js"></script>
<script src="<?php echo URL_ROOT; ?>/js/hammer.min.js"></script>
<script src="<?php echo URL_ROOT; ?>/js/TweenMax.min.js"></script>
<script src="<?php echo URL_ROOT; ?>/js/jquery.pinchzoomer.min.js"></script>
<script src="<?php echo URL_ROOT; ?>/js/masonry_example.js"></script>
<div class="hiddenStuff">
  <div class="zoomHolder">
  <div data-elem="tempItem"></div>
  <?php foreach($data['photos'] as $photo) : ?>
    <div class="grid-item" data-elem="pzItem" data-grid-options="thumbUrl:<?php echo URL_ROOT; ?>/uploads/work/<?php echo $photo->filename; ?>;">
      <img src="#" data-src="<?php echo URL_ROOT; ?>/uploads/work/<?php echo $photo->filename; ?>" data-elem="bg" alt="">
    </div>
  <?php endforeach; ?>
  </div>
</div>
<div class="hiddenStuff">
      <div class="zoomHolder" style="overflow: hidden;">
          <div data-elem="tempItem" style="height: 0px; width: 0px; touch-action: pan-x pan-y; user-select: none; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); cursor: pointer; opacity: 1; image-rendering: auto; backface-visibility: hidden; transform: matrix(1, 0, 0, 1, 0, 0);">
      </div>
      <div class="controlHolder" data-elem="controlHolder"><div class="zoomIn on" style=""></div><div class="zoomOut off" style=""></div><div class="fullscreenToggle off" style=""></div></div></div>
  </div>
<?php require APP_ROOT . '/views/includes/footer.php'; ?>