<?php
/**
 * @var $this DefaultController
 * @var $data BlogContent
 * @var $full bool
 * @var bool $showTitle
 */

$post = $data->post;
?>
<?php if ($full):?>
    <h2 class="b-article_t">
        <?=$data->title ?> <?php $this->widget('site.frontend.widgets.favoritesWidget.FavouritesWidget', array('model' => $data)); ?>
    </h2>

    <div class="b-article_in clearfix">
        <div class="wysiwyg-content clearfix">
            <div class="b-article_in-img">
                <?=$data->video->embed?>
            </div>
            <?=$data->video->purified->text ?>
        </div>
    </div>
<?php else: ?>
    <?php if ($showTitle):?>
        <h2 class="b-article_t">
            <?php if ($show_new && ViewedPost::getInstance()->isViewed($data->id)): ?>
                <div class="b-article_t-new">новое</div>
            <?php endif ?>
            <a href="<?=$data->getUrl() ?>" class="b-article_t-a"><?=$data->title ?></a>
        </h2>
    <?php endif ?>

    <div class="b-article_in clearfix">
        <div class="wysiwyg-content clearfix">
            <div class="b-article_in-img">
                <?=$data->video->embed?>
            </div>
            <p><?=$data->getContentText(500, '') ?></p>
        </div>
    </div>

<?php endif ?>