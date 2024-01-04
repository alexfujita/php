<?php require APP_ROOT . '/views/includes/header.php'; ?>
<div class="container--inner">
    <h1>
        <svg xmlns="http://www.w3.org/2000/svg" width="104.081" height="68.825" viewBox="0 0 104.081 68.825">
            <path d="xxx" transform="translate(1.954 65.141) rotate(-4)" fill="#b26a6a"/>
        </svg>
    </h1>
    <?php foreach($data as $news) : ?>
    <div class="row row--news ja">
        <?php if ($news->image) : ?>
        <div class="news--image">
            <?php if ($news->work_id) : ?>
            <a href="<?php echo URL_ROOT; ?>/work/<?php echo $news->work_id; ?>">
            <?php else : ?>
            <a href="<?php echo $news->link; ?>" target="_blank">
            <?php endif; ?>
                <img src="<?php echo URL_ROOT; ?>/uploads/works/<?php echo $news->image; ?>" alt="">
            </a>
            
        </div>
        <?php endif; ?>
        <div class="column--news">
            <p class="news--date"><?php echo $news->date; ?></p>
            <p class="news--title"><?php echo $news->title; ?></p>
            <p class="news--body"><?php echo $news->body; ?></p>
        </div>
    </div>
    <?php endforeach; ?> 
</div>

<?php require APP_ROOT . '/views/includes/footer.php'; ?>