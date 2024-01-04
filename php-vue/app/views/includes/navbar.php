<nav class="navbar nav-extended red lighten-1">
  <div class="nav-wrapper">
    <a href="<?php echo URL_ROOT; ?>" class="brand-logo"><?php echo SITE_NAME; ?></a>
    <ul id="nav-mobile">
    <?php if(isset($_SESSION['login_id'])) : ?>  
      <li>
        <a class="navbar-brand" href="<?php echo URL_ROOT; ?>/index/logout">
          <i class="material-icons">open_in_new</i>ログアウト
        </a>
      </li>
    <?php else : ?>
      <li>
        <a class="navbar-brand" href="<?php echo URL_ROOT; ?>">
          <i class="material-icons">exit_to_app</i>ログイン
        </a>
      </li>
    <?php endif; ?>
    </ul>
  </div>
  <div class="nav-content">
      <ul class="tabs tabs-transparent">
        <li><a class="navbar-brand" href="<?php echo URL_ROOT; ?>/mtgroom"><i class="material-icons">developer_board</i>ミーティングルーム</a></li>
        <li><a class="navbar-brand" href="<?php echo URL_ROOT; ?>/potatoblog"><i class="material-icons">format_bold</i>ポテトブログ</a></li>
        <li><a class="navbar-brand" href="<?php echo URL_ROOT; ?>/bags"><i class="material-icons">crop_original</i>プロフィール画像</a></li>
        <li><a class="navbar-brand" href="<?php echo URL_ROOT; ?>/news"><i class="material-icons">event_note</i>お知らせ</a></li>
        <li><a class="navbar-brand" href="<?php echo URL_ROOT; ?>/members"><i class="material-icons">people</i>ポイント</a></li>

      </ul>
    </div>
</nav>

