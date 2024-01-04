 <section id="area_archive">
    <div class="container">
        <div class="row">
            <div class="itemset bottommenu">
                <div class="inner">
                    <div id="archivelist">
                        <div class="menuset">
                            <div class="itemInner">
                                <div class="title">◯◯ミーティングルーム アーカイブ</div>
                                <ul>
                                <?php foreach($data['mtgrooms'] as $mtgrooms) : ?>
                                    <li><a href="<?php echo $mtgrooms->slug; ?>">◯◯ ミーティング用アンケート<?php echo $mtgrooms->slug; ?></a></li>
                                <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>