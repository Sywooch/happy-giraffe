<?php
/**
 * @var AlbumPhoto $data
 */
?>

<article class="b-article clearfix">
    <div class="float-l">
        <div class="like-control like-control__small-indent clearfix">
            <?php $this->widget('site.frontend.widgets.userAvatarWidget.Avatar', array('user' => $data->author)); ?>
        </div>
        <div class="like-control clearfix">
            <?php $this->widget('application.modules.blog.widgets.LikeWidget', array('model' => $data)); ?>

            <!-- ko stopBinding: true -->
            <?php $this->widget('FavouriteWidget', array('model' => $data, 'right' => true)); ?>
            <!-- /ko -->
        </div>
    </div>
    <div class="b-article_cont clearfix">
        <div class="b-article_cont-tale"></div>
        <div class="b-article_header clearfix">
            <div class="meta-gray">
                <a href="<?=$data->getUrl(true)?>" class="meta-gray_comment"><span class="ico-comment ico-comment__gray"></span><span class="meta-gray_tx"><?=$data->getCommentsCount()?></span></a>
                <div class="meta-gray_view"><span class="ico-view ico-view__gray"></span><span class="meta-gray_tx"><?=PageView::model()->viewsByPath($data->getUrl())?></span></div>
            </div>
            <div class="float-l"><a href="<?=$data->author->getUrl()?>" class="b-article_author"><?=$data->author->getFullName()?></a><span class="b-article_date"><?=HDate::GetFormattedTime($data->created)?></span></div>
        </div>
        <?php if (! empty($data->title)): ?>
            <h2 class="b-article_t"><a href="<?=$data->url?>" class="b-article_t-a"><?=$data->title?></a></h2>
        <?php endif; ?>
        <div class="b-article_in clearfix">
            <div class="wysiwyg-content clearfix">
                <div class="b-article_in-img"><?=CHtml::link(CHtml::image($data->getPreviewUrl(580, null, Image::WIDTH)), $data->getUrl())?></div>
            </div>
        </div>
        <?php if ($data->album !== null): ?>
        <div class="font-s margin-l20 margin-b30">к <?=CHtml::link($data->album->title, $data->album->getUrl())?></div>
        <?php endif; ?>
    </div>
</article>