<?php
/**
 * @var $data BlogContent
 */
$prev = $data->getPrevPost();
$next = $data->getNextPost();

if (!empty($next) || !empty($prev)){
?>
<div class="nav-article clearfix">
    <?php if (!empty($prev)): ?>
        <div class="nav-article_left">
            <a href="<?= $prev->getUrl() ?>" class="nav-article_arrow nav-article_arrow__left"></a>
            <a href="<?= $prev->getUrl() ?>" class="nav-article_a"><?= $prev->title ?></a>
        </div>
    <?php endif ?>
    <?php if (!empty($next)): ?>
        <div class="nav-article_right">
            <a href="<?= $next->getUrl() ?>" class="nav-article_arrow nav-article_arrow__right"></a>
            <a href="<?= $next->getUrl() ?>" class="nav-article_a"><?= $next->title ?></a>
        </div>
    <?php endif ?>
</div><?php }