<div class="meta">
    <div class="views"><span class="icon" href="#"></span> <span><?=PageView::model()->viewsByPath($model->url)?></span></div>
    <?php if ($model->commentsCount == 0): ?>
        <div class="comments empty">
            <a class="icon" href="<?=$model->getUrl(true)?>"></a>
        </div>
    <?php else: ?>
        <div class="comments">
            <a class="icon" href="<?=$model->getUrl(true)?>"></a>
            <a href="<?=$model->getUrl(true)?>"><?=$model->commentsCount?></a>
        </div>
    <?php endif; ?>
</div>