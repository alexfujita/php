<?php require APP_ROOT . '/views/includes/header.php'; ?>
<div class="container--inner">
    <h1>
        <svg xmlns="http://www.w3.org/2000/svg" width="121.688" height="65.092" viewBox="0 0 121.688 65.092">
            <path d="xxx" transform="translate(4.053 66.41) rotate(-4)" fill="#b26a6a"/>
        </svg>
    </h1>
    <div class="works row">
        <?php foreach($data as $work) : ?>
        <div class="column col-works">
            <a href="<?php echo URL_ROOT; ?>/work/<?php echo $work->id; ?>">
            <div style="background-image: url(<?php echo URL_ROOT; ?>/public/uploads/works/<?php echo $work->photo; ?>); background-size: cover; width: 100%" class="work-thumb">
            </div>
            </a>

            <p><?php echo $work->property_en; ?>
            <br>
                <span><?php echo $work->year; ?></span>
                <?php if($work->location_en) : ?>
                <span>/</span>
                <span><?php echo $work->location_en; ?></span>
                <?php endif; ?>

                <?php if($work->category_en) : ?>
                <span>/</span>
                <span><?php echo $work->category_en; ?></span>
                <?php endif; ?>
            </p>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?php require APP_ROOT . '/views/includes/footer.php'; ?>