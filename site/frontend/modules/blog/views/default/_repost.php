<?php
/**
 * @var $this DefaultController
 * @var $data BlogContent
 * @var $full bool
 */

$source = $data->source;
?>
<div class="clearfix">
    <div class="float-l">
        <div class="like-control like-control__repost clearfix">
            <?php $this->widget('Avatar', array('user' => $data->author)) ?>
            <span class="like-control_repost-complete"></span>
        </div>
    </div>

    <div class="b-article_cont clearfix">
        <div class="b-article_cont-tale"></div>
        <div class="b-article_header clearfix">
            <div class="float-l">
                <a href="<?= $data->author->getUrl() ?>" class="b-article_author"><?= $data->author->getFullName() ?></a>
                <span class="font-smallest color-gray"><?= Yii::app()->dateFormatter->format("d MMMM yyyy, H:mm", $data->created) ?></span>
            </div>
        </div>
        <h2 class="b-article_t">
            <p><?= $source->title ?></p>
        </h2>
        <?php if (!empty($data->preview)):?>
        <div class="b-article_repost-comment">
            <?= $data->preview ?>
        </div>
        <?php endif ?>
    </div>
</div>