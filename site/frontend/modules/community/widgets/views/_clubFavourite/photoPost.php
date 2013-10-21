<?php
/**
 * @var CommunityContent $post
 */
?>

<div class="such-post_i such-post_i__photopost">
    <a href="javascript:void(0)" class="such-post_img-hold" onclick="PhotoCollectionViewWidget.open(<?=CJavaScript::encode('PhotoPostPhotoCollection')?>, <?=CJavaScript::encode(array('contentId' => $post->id))?>, <?=CJavaScript::encode(null)?>, <?=CJavaScript::encode(array('exitUrl' => $post->getUrl()))?>)">
        <?=CHtml::image($post->gallery->items[0]->photo->getPreviewUrl(335, null, Image::WIDTH), $post->title, array('class' => 'such-post_img'))?>
        <span class="such-post_img-overlay"></span>
        <span class="such-post_tip"><?=$post->gallery->count?> фото</span>
    </a>
    <div class="such-post_type-hold">
        <div class="such-post_type such-post_type__photopost"></div>
    </div>
    <div class="such-post_cont">
        <div class="clearfix">
            <div class="meta-gray">
                <a class="meta-gray_comment" href="<?= $post->getUrl(true)?>">
                    <span class="ico-comment ico-comment__white"></span>
                    <span class="meta-gray_tx color-gray-light"><?=$post->getCommentsCount()?></span>
                </a>
                <div class="meta-gray_view">
                    <span class="ico-view ico-view__white"></span>
                    <span class="meta-gray_tx color-gray-light"><?=PageView::model()->viewsByPath($post->getUrl())?></span>
                </div>
            </div>
            <div class="such-post_author">
                <?php $this->widget('Avatar', array('user' => $post->by_happy_giraffe ? User::model()->findByPk(1) : $post->author, 'size' => 40)); ?>
                <a href="<?=$post->author->getUrl()?>" class="such-post_author-name"><?=$post->author->getFullName()?></a>
                <div class="such-post_date"><?=Yii::app()->dateFormatter->format("d MMMM yyyy, H:mm", $post->created)?></div>
            </div>

        </div>
        <a href="<?=$post->getUrl()?>" class="such-post_t"><?=$post->title?></a>
    </div>
</div>