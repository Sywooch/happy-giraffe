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
    <h1 class="b-article_t">
        <?=$data->title ?>
        <?php $this->widget('site.frontend.widgets.favoritesWidget.FavouritesWidget', array('model' => $data)); ?>
    </h1>

    <?php $this->renderPartial('//banners/_post_header', compact('data')); ?>

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
        <div class="b-article_t">
            <?php if ($show_new && ViewedPost::getInstance()->isViewed($data->id)): ?>
                <div class="b-article_t-new">новое</div>
            <?php endif ?>
            <a href="<?=$data->getUrl() ?>" class="b-article_t-a"><?=$data->title ?></a>
            <?php $this->widget('site.frontend.widgets.favoritesWidget.FavouritesWidget', array('model' => $data)); ?>
        </div>
    <?php endif ?>

    <div class="b-article_in clearfix">
        <div class="wysiwyg-content clearfix">
            <div class="b-article_in-img">
                <?=$data->video->embed?>
            </div>
        </div>
    </div>

    <?php if ($data->hasMoreText()):?>
        <div class="textalign-r margin-15">
            <a href="<?=$data->getUrl() ?>" class="b-article_more">Смотреть далее</a>
        </div>
    <?php endif ?>

<?php endif ?>