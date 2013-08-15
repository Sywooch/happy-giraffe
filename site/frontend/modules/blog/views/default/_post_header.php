<?php
/**
 * @var $model BlogContent
 */
if (!isset($author))
    $author = $model->author;

?><div class="b-article_header clearfix">
    <div class="meta-gray">
        <a href="<?= $model->getUrl(true) ?>" class="meta-gray_comment">
            <span class="ico-comment ico-comment__gray"></span>
            <span class="meta-gray_tx"><?=$model->getUnknownClassCommentsCount() ?></span>
        </a>
        <div class="meta-gray_view">
            <span class="ico-view ico-view__gray"></span>
            <span class="meta-gray_tx"><?= $full ? $this->getViews() : PageView::model()->viewsByPath($model->getUrl()) ?></span>
        </div>
    </div>
    <div class="float-l">
        <a href="<?=$author->getUrl() ?>" class="b-article_author"><?=$author->getFullName() ?></a>
        <span class="font-smallest color-gray"><?=Yii::app()->dateFormatter->format("d MMMM yyyy, H:mm", $model->created)?></span>
    </div>
</div>