<?php require APP_ROOT . '/views/includes/header.php'; ?>

<div class="container--inner">
    <h3><?php echo $data['work']->property_en; ?></h3>
    <p>
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
    <p><?php echo $data['work']->description; ?></p>
    <div id="grid">
    </div>
  </div>
<script src="<?php echo URL_ROOT; ?>/js/jquery.min.js"></script>  
<script src="<?php echo URL_ROOT; ?>/js/masonry.min.js"></script> 
<script src="<?php echo URL_ROOT; ?>/js/imagesloaded.min.js"></script> 
<script src="<?php echo URL_ROOT; ?>/js/tooltipster.bundle.min.js" type="text/javascript"></script>
<script src="<?php echo URL_ROOT; ?>/js/hammer.min.js"></script>
<script src="<?php echo URL_ROOT; ?>/js/TweenMax.min.js"></script>
<script src="<?php echo URL_ROOT; ?>/js/jquery.pinchzoomer.min.js"></script>
<script src="<?php echo URL_ROOT; ?>/js/masonry_example.js"></script>

<script>
var $grid = $('#grid').masonry({
  columnWidth: '.grid-item',
  itemSelector: '.grid-item',
  percentPosition: true
});
$grid.imagesLoaded().progress( function() {
  $grid.masonry('layout');
});
</script>
<?php require APP_ROOT . '/views/includes/footer.php'; ?>

<div class="hiddenStuff">
  <div class="zoomHolder">
  <div data-elem="tempItem"></div>
  </div>
  <?php foreach($data['photos'] as $photo) : ?>
    <div data-elem="pzItem" data-grid-options="thumbUrl:<?php echo URL_ROOT; ?>/uploads/works/<?php echo $photo->filename; ?>;">
      <img src="#" data-src="<?php echo URL_ROOT; ?>/uploads/works/<?php echo $photo->filename; ?>" data-elem="bg" alt="">
    </div>
  <?php endforeach; ?>
</div>