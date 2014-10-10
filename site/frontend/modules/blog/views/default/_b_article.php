<?php
/**
 * @var CommunityContent $model
 * @var bool $showLikes
 */
?>

<div class="b-article b-article-prev clearfix">
    <?php if ($showLikes): ?>
    <div class="float-l">
        <div class="like-control like-control__smallest clearfix">
            <?php if ($ad = $model->isAd()): ?>
                <span class="ava middle">
                    <?=CHtml::image($ad['img'], $ad['text'])?>
                </span>
            <?php else: ?>
                <?php $this->widget('Avatar', array('user' => $model->author, 'size' => 40)) ?>
            <?php endif; ?>
            <?php $this->widget('application.modules.blog.widgets.LikeWidget', array('model' => $model)); ?>
            <!-- ko stopBinding: true -->
            <?php $this->widget('application.modules.blog.widgets.RepostWidget', array('model' => $model, 'right' => true)); ?>
            <!-- /ko -->
            <!-- ko stopBinding: true -->
            <?php $this->widget('FavouriteWidget', array('model' => $model, 'right' => true)); ?>
            <!-- /ko -->
        </div>
    </div>
    <?php endif; ?>
    <div class="b-article-prev_cont clearfix">
        <div class="clearfix">
            <div class="meta-gray">
                <a class="meta-gray_comment" href="">
                    <span class="ico-comment ico-comment__gray"></span>
                    <span class="meta-gray_tx"><?=$model->getCommentsCount()?></span>
                </a>
                <div class="meta-gray_view">
                    <span class="ico-view ico-view__gray"></span>
                    <span class="meta-gray_tx"><?=PageView::model()->viewsByPath($model->getUrl())?></span>
                </div>
            </div>
            <div class="float-l">
                <div class="clearfix">
                    <?php if ($ad = $model->isAd()): ?>
                        <span class="b-article-prev_author" style="color: #289fd7;"><?=$ad['text']?></span>
                    <?php else: ?>
                        <a class="b-article-prev_author" href="<?=$model->author->getUrl() ?>"><?=$model->author->first_name ?></a>
                    <?php endif; ?>
                </div>
                <span class="font-smallest color-gray"><?=HDate::GetFormattedTime($model->created)?></span>
            </div>
        </div>
        <div class="b-article-prev_t clearfix">
            <a class="b-article-prev_t-a" href="<?=$model->url?>"><?=$model->title?></a>
            <?php if ($model->contestWork !== null): ?>
                <span class="b-article-prev_t-count"><?=$model->contestWork->rate?></span>
            <?php endif; ?>
        </div>
        <div class="b-article-prev_in">
            <?php if ($model->type_id == CommunityContent::TYPE_POST): ?>
                <?php if (($photo = $model->getPhoto()) !== null): ?>
                    <div class="b-article_in-img">
                        <?=CHtml::image($photo->getPreviewUrl(235, null, Image::WIDTH), $photo->title, array('class' => 'content-ing'))?>
                    </div>
                <?php elseif($model->getAttributePhotoCollection('preview', false) && $model->getAttributePhotoCollection('preview')->attachesCount > 0): ?>
                    <div class="b-article_in-img">
                        <?=CHtml::image(\Yii::app()->thumbs->getThumb($model->getAttributePhotoCollection('preview')->attaches[0]->photo, 'postPreviewSmall')->getUrl(), $model->getAttributePhotoCollection('preview')->attaches[0]->photo->title, array('class' => 'content-ing'))?>
                    </div>
                <?php else: ?>
                    <p><?=$model->getContentText(256)?></p>
                <?php endif; ?>
            <?php endif; ?>
            <?php if ($model->type_id == CommunityContent::TYPE_VIDEO): ?>
                <div class="b-article_in-img">
                    <?=$model->video->embed?>
                </div>
            <?php endif; ?>
            <?php if ($model->type_id == CommunityContent::TYPE_PHOTO_POST): ?>
                <div class="b-article_in-img">
                    <?php $this->widget('PhotoCollectionViewWidget', array('width' => 235, 'maxHeight' => 100, 'borderSize' => 1, 'href' => $model->url, 'maxRows' => 3, 'minPhotos' => 1, 'collection' => new PhotoPostPhotoCollection(array('contentId' => $model->id)))); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>