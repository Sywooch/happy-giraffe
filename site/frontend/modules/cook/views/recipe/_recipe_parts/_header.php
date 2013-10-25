<div class="b-article_cont-tale"></div>
<div class="b-article_header clearfix">
    <div class="meta-gray">
        <a href="<?= $recipe->getUrl(true) ?>" class="meta-gray_comment">
            <span class="ico-comment ico-comment__gray"></span>
            <span class="meta-gray_tx"><?=$recipe->commentsCount ?></span>
        </a>
        <div class="meta-gray_view">
            <span class="ico-view ico-view__gray"></span>
            <span class="meta-gray_tx"><?=($full) ? $this->getViews() : PageView::model()->viewsByPath($recipe->url)?></span>
        </div>
    </div>
    <div class="float-l">
        <a href="<?=$recipe->author->getUrl() ?>" class="b-article_author"><?=$recipe->author->getFullName() ?></a>
        <span class="font-smallest color-gray"><?=Yii::app()->dateFormatter->format("d MMMM yyyy, H:mm", $recipe->created)?></span>
    </div>
</div>