<?php 

$url_path = $_SERVER['REQUEST_URI']; 
$cur_path = substr(strrchr($url_path, '/'), 1);
?>

<nav class="container mx-4">
  <div>
    <div class="flex space-between">
      <a href="<?php echo URL_ROOT; ?>"><img src="<?php echo img('logo/logo.svg'); ?>" alt=""></a>
      <div>
        <ul class="flex flex-end">
          <li <?php echo $cur_path === 'works' ? 'class="active"' : null; ?>><a href="works">WORKS</a></li>
          <li <?php echo $cur_path === 'profile' ? 'class="active"' : null; ?>><a href="profile">PROFILE</a></li>
          <li <?php echo $cur_path === 'news' ? 'class="active"' : null; ?>><a href="news">NEWS</a></li>
          <li <?php echo $cur_path === 'recruit' ? 'class="active"' : null; ?>><a href="recruit">RECRUIT</a></li>
          <li <?php echo $cur_path === 'contact' ? 'class="active"' : null; ?>><a href="contact">CONTACT</a></li>
        </ul>
      </div>
    </div>
  </div>
</nav>

