<!-- ヘッダー -->
<header style="padding-top: <?php echo ($data['page'] == 'show') ? '114px' : '158px' ?>">
    <!-- ヘッダー画像 -->
    <section id="area_headerimg">
    <div class="container">
        <div class="row">
        <div class="mainimage">
            <h1 class="">
            <img
                src="<?php echo URL_MYPAGE; ?>/img/img_title_pc.png"
                alt="◯◯"
            />
            </h1>
        </div>
        </div>
    </div>
    </section>
</header>

<?php if(isset($data['blog'])) : ?>
<!-- blog -->
<section id="area_blog">
  <div class="container">
    <div class="row">
      <h2 class="title">
        <div>
          <div>
            <span>
              <img src="<?php echo img('svg/icon_title.svg'); ?>" alt="◯◯ブログ" class="icon vCenter">
            </span>
            <span>◯◯ブログ</span>
          </div>
        </div>
      </h2>
<?php endif; ?>