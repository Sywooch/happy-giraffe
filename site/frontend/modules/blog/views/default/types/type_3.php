<?php
/**
 * @var $this DefaultController
 * @var $data BlogContent
 * @var $full bool
 * @var bool $showTitle
 */

$post = $data->photoPost;
$collection = new PhotoPostPhotoCollection(array('contentId' => $data->id));
?>
<?php if ($full):?>
    <h2 class="b-article_t">
        <?=$data->title ?>
        <?php $this->widget('site.frontend.widgets.favoritesWidget.FavouritesWidget', array('model' => $data)); ?>
    </h2>

    <div class="b-article_in clearfix">
        <div class="wysiwyg-content clearfix">
            <p><?=str_replace("\n", '<br>', $data->photoPost->text) ?></p>
        </div>
        <?php
        $this->widget('PhotoCollectionViewWidget', array(
            'collection' => $collection,
            'width' => 580,
        ));
        ?>
    </div>
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
            <?= $data->purified->preview ?>
        </div>
        <?php
        $this->widget('PhotoCollectionViewWidget', array(
            'collection' => $collection,
            'width' => 580,
            'maxRows' => 2,
        ));
        ?>
    </div>

    <div class="textalign-r margin-15">
        <a href="<?=$data->getUrl() ?>" class="b-article_more">Смотреть <?=$collection->count?> фото</a>
    </div>
<?php endif ?>