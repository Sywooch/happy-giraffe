<?php
/**
 * @var $this DefaultController
 * @var $data BlogContent
 */

$post = $data->post;
?>
<div class="b-article b-article__preview clearfix">
    <div class="float-l">
        <?php $this->renderPartial('preview/_post_controls', array('model' => $data)); ?>
    </div>
    <div class="b-article_cont clearfix">
        <div class="b-article_cont-tale"></div>

        <?php $this->renderPartial('_post_header', array('model' => $data)); ?>

        <h2 class="b-article_t">
            <a href="<?=$data->getUrl() ?>" class="b-article_t-a"><?=$data->title ?></a>
        </h2>

        <div class="b-article_in clearfix">
            <div class="wysiwyg-content clearfix">
                <p><?=$data->getContentText(500, '') ?></p>
                <?php if ($photo = $data->getPhoto()):?>
                    <div class="b-article_in-img">
                        <img src="<?=$photo->getPreviewUrl(580, 1000, Image::WIDTH) ?>" class="content-img">
                    </div>
                <?php endif ?>
            </div>
        </div>

        <div class="textalign-r margin-15">
            <a href="<?=$data->getUrl() ?>" class="b-article_more">Смотреть далее</a>
        </div>

        <?php $this->widget('application.widgets.newCommentWidget.NewCommentWidget', array('model' => $data)); ?>

    </div>
</div>