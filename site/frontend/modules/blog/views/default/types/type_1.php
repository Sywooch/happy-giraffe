<?php
/**
 * @var $this DefaultController
 * @var $data BlogContent
 * @var $full bool
 * @var bool $showTitle
 */

$post = $data->post;
$photo = $data->getPhoto()
?>
<?php if ($full):?>
    <h2 class="b-article_t">
        <?=$data->title ?>
        <?php $this->widget('site.frontend.widgets.favoritesWidget.FavouritesWidget', array('model' => $data)); ?>
    </h2>

    <div class="b-article_in clearfix">
        <div class="wysiwyg-content clearfix">
            <?=$data->post->purified->text ?>
        </div>
    </div>
    <?php if ($data->gallery !== null) $this->renderPartial('photo_gallery', array('data' => $data)); ?>
<?php else: ?>
    <?php if ($showTitle):?>
        <h2 class="b-article_t">
            <?php if ($show_new && ViewedPost::getInstance()->isViewed($data->id)): ?>
                <div class="b-article_t-new">новое</div>
            <?php endif ?>
            <a href="<?=$data->getUrl() ?>" class="b-article_t-a"><?=$data->title ?></a>
            <?php $this->widget('site.frontend.widgets.favoritesWidget.FavouritesWidget', array('model' => $data)); ?>
        </h2>
    <?php endif ?>

    <div class="b-article_in clearfix">
        <div class="wysiwyg-content clearfix">
            <?=$data->preview ?>
            <?php if ($photo && $photo->width >= 580):?>
                <div class="b-article_in-img">
                    <img src="<?=$photo->getPreviewUrl(580, 1100) ?>" class="content-img"<?php if ($photo->title) echo ' alt="'.$photo->title.'" title="'.$photo->title.'"'?>>
                </div>
            <?php endif ?>
        </div>
    </div>

    <div class="textalign-r margin-15">
        <a href="<?=$data->getUrl() ?>" class="b-article_more">Смотреть далее</a>
    </div>
<?php endif ?>