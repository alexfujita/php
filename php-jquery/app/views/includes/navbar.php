<?php 

$url_path = $_SERVER['REQUEST_URI']; 
$cur_path = substr(strrchr($url_path, '/'), 1);
?>

<nav id="top--nav">
    <div class="nav--header">
		<!-- logo -->
		<a href="<?php echo URL_ROOT; ?>" class="inherit logo">
			<svg id="logo" xmlns="http://www.w3.org/2000/svg" width="159.773" height="43.039" viewBox="0 0 159.773 43.039">
				<path d="M112.817,11.797c1.624,0,2.939-1.316,2.939-2.94c0-1.624-1.315-2.94-2.939-2.94s-2.94,1.316-2.94,2.94
			C109.877,10.481,111.193,11.797,112.817,11.797L112.817,11.797"/>
				<path d="xxx"/>
			</svg>
		</a>

		<!-- hamburger menu -->
		<div class="hamburger-icons">
			<button class="hamburger">
				<img src="<?php echo URL_ROOT; ?>/icons/hamburger.png" alt="">
			</button>
			<button class="cross">
				<img src="<?php echo URL_ROOT; ?>/icons/multiply.png" alt="">
			</button>
		</div>


		<!-- menu links -->
		<ul class="top--menu">
			<li <?php echo $cur_path === 'works' ? 'class="active"' : null; ?>><a href="<?php echo URL_ROOT; ?>/works">WORKS</a></li>
			<li <?php echo $cur_path === 'profile' ? 'class="active"' : null; ?>><a href="<?php echo URL_ROOT; ?>/profile">PROFILE</a></li>
			<li <?php echo $cur_path === 'news' ? 'class="active"' : null; ?>><a href="<?php echo URL_ROOT; ?>/news">NEWS</a></li>
			<li <?php echo $cur_path === 'recruit' ? 'class="active"' : null; ?>><a href="<?php echo URL_ROOT; ?>/recruit">RECRUIT</a></li>
			<li <?php echo $cur_path === 'contact' ? 'class="active"' : null; ?>><a href="<?php echo URL_ROOT; ?>/contact">CONTACT</a></li>
		</ul>
    </div>


</nav>