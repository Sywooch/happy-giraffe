<?php
/**
 * @var $model BlogContent
 */
if (!isset($author))
    $author = $model->author;

if ($model->by_happy_giraffe)
    $author = User::model()->findByPk(1);

?><div class="b-article_header clearfix">
    <div class="meta-gray">
        <a href="<?= $model->getUrl(true) ?>" class="meta-gray_comment">
            <span class="ico-comment ico-comment__<?=($model->type_id == CommunityContentType::TYPE_PHOTO) ? 'white' : 'gray'?>"></span>
            <span class="meta-gray_tx<?php if ($model->type_id == CommunityContentType::TYPE_PHOTO): ?> color-gray-light<?php endif; ?>"><?=$model->getCommentsCount() ?></span>
        </a>
        <div class="meta-gray_view">
            <span class="ico-view ico-view__<?=($model->type_id == CommunityContentType::TYPE_PHOTO) ? 'white' : 'gray'?>"></span>
            <span class="meta-gray_tx<?php if ($model->type_id == CommunityContentType::TYPE_PHOTO): ?> color-gray-light<?php endif; ?>"><?= $full ? $this->getViews() : PageView::model()->viewsByPath($model->getUrl()) ?></span>
        </div>
    </div>
    <div class="float-l">
        <?php if ($ad = $model->isAd()): ?>
            <span class="b-article_author" style="text-decoration: none;"><?=$ad['text']?></span>
        <?php else: ?>
            <a href="<?=$author->getUrl() ?>" class="b-article_author"><?=$author->getFullName() ?></a>
        <?php endif; ?>
        <span class="b-article_date"><?=Yii::app()->dateFormatter->format("d MMMM yyyy, H:mm", $model->created)?></span>
    </div>
</div>