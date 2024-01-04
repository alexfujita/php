<?php require APP_ROOT . '/views/includes/header.php'; ?>

    <div class="container--inner top--message" id="top--text">
            <div class="top--message-en-container">
                <picture>
                    <source media="(max-width: 767px)" srcset="<?php echo URL_ROOT; ?>/img/message-smp-en.png">
                    <source media="(max-width: 1023px)" srcset="<?php echo URL_ROOT; ?>/img/message-tablet-en.png">
                    <source media="(min-width: 1024px)" srcset="<?php echo URL_ROOT; ?>/img/message-en.png">
                    <img src="<?php echo URL_ROOT; ?>/img/message-en.png" alt="">
                </picture>
            </div>
            <div class="top--message-ja-container">
                <picture>
                    <source media="(max-width: 767px)" srcset="<?php echo URL_ROOT; ?>/img/message-smp-ja.png">
                    <source media="(max-width: 1023px)" srcset="<?php echo URL_ROOT; ?>/img/message-tablet-ja.png">
                    <source media="(min-width: 1024px)" srcset="<?php echo URL_ROOT; ?>/img/message-ja.png">
                    <img src="<?php echo URL_ROOT; ?>/img/message-ja.png" alt="">
                </picture>
            </div>
    </div>

<?php require APP_ROOT . '/views/includes/footer.php'; ?>
<script>
    if (showIntro) {
        $('.top--message').hide().visible().delay(14000).fadeIn(1000);
        $('#top--nav').hide().visible().delay(14000).fadeIn(1000);
        $('.footer').hide().visible().delay(14000).fadeIn(1000);
    }

</script>