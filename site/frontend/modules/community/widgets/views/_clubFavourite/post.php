<?php
/**
 * @var CommunityContent $post
 */
?>

<div class="such-post_i">
    <a href="<?=$post->getUrl()?>" class="such-post_img-hold">
        <?=CHtml::image($post->getPhoto()->getPreviewUrl(335, null, Image::WIDTH), $post->title, array('class' => 'such-post_img'))?>
    </a>
    <div class="such-post_type-hold">
        <div class="such-post_type such-post_type__<?=$post->type_id == 1 ? 'post' : 'video'?>"></div>
    </div>
    <div class="such-post_cont">
        <div class="clearfix">
            <div class="meta-gray">
                <a class="meta-gray_comment" href="<?= $post->getUrl(true)?>">
                    <span class="ico-comment ico-comment__gray"></span>
                    <span class="meta-gray_tx"><?=$post->getCommentsCount()?></span>
                </a>
                <div class="meta-gray_view">
                    <span class="ico-view ico-view__gray"></span>
                    <span class="meta-gray_tx"><?=PageView::model()->viewsByPath($post->getUrl())?></span>
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