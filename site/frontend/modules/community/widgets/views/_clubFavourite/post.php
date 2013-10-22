<?php
/**
 * @var CommunityContent $post
 */

$photoUrl = ($post->getPhoto()->width > $post->getPhoto()->height) ? $photo->getPreviewUrl(335, null, Image::WIDTH) : $photo->getPreviewUrl(335, 230, Image::INVERT, true, AlbumPhoto::CROP_SIDE_TOP);
?>

<div class="such-post_i">
    <a href="<?=$post->getUrl()?>" class="such-post_img-hold">
        <?=CHtml::image($photoUrl, $post->title, array('class' => 'such-post_img'))?>
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
                <div class="such-post_date"><?=HDate::GetFormattedTime($post->created)?></div>
            </div>

        </div>
        <a href="<?=$post->getUrl()?>" class="such-post_t"><?=$post->title?></a>
    </div>
</div>