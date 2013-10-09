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
    <h1 class="b-article_t">
        <?=$data->title ?>
        <?php $this->widget('site.frontend.widgets.favoritesWidget.FavouritesWidget', array('model' => $data)); ?>
    </h1>

    <div class="b-article_in clearfix">
        <div class="wysiwyg-content clearfix">
            <p><?=nl2br(CHtml::encode($data->photoPost->text))?></p>
        </div>
        <div class="textalign-c">
            <a class="b-article_more" href="javascript:void(0)" onclick="PhotoCollectionViewWidget.open(<?=CJavaScript::encode(get_class($collection))?>, <?=CJavaScript::encode($collection->options)?>, <?=CJavaScript::encode($collection->photoIds[0])?>)">Смотреть <?=$collection->count?> фото</a>
        </div>
        <?php $this->widget('PhotoCollectionViewWidget', array(
            'collection' => $collection,
            'width' => 580,
        )); ?>
        <div class="textalign-c">
            <a class="b-article_more" href="javascript:void(0)" onclick="PhotoCollectionViewWidget.open(<?=CJavaScript::encode(get_class($collection))?>, <?=CJavaScript::encode($collection->options)?>, <?=CJavaScript::encode($collection->photoIds[0])?>)">Смотреть <?=$collection->count?> фото</a>
        </div>
    </div>

    <?php if (Yii::app()->request->getQuery('openGallery') !== null): ?>
        <script type="text/javascript">
            PhotoCollectionViewWidget.open(<?=CJavaScript::encode(get_class($collection))?>, <?=CJavaScript::encode($collection->options)?>, <?=CJavaScript::encode($collection->photoIds[0])?>);
        </script>
    <?php endif; ?>
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
        <?php //if (!empty($data->preview)):?>
            <div class="wysiwyg-content clearfix">
                <?= $data->purified->preview ?>
            </div>
        <?php //endif ?>
        <?php
        $this->widget('PhotoCollectionViewWidget', array(
            'collection' => $collection,
            'width' => 580,
            'maxRows' => 2,
            'windowOptions' => array(
                'exitUrl' => $data->getUrl(),
            ),
        ));
        ?>
    </div>

    <div class="textalign-r margin-15">
        <a href="javascript:void(0)" class="b-article_more" onclick="PhotoCollectionViewWidget.open(<?=CJavaScript::encode(get_class($collection))?>, <?=CJavaScript::encode($collection->options)?>, <?=CJavaScript::encode($collection->photoIds[0])?>, <?=CJavaScript::encode(array('exitUrl' => $data->getUrl()))?>)">Смотреть <?=$collection->count?> фото</a>
    </div>
<?php endif ?>