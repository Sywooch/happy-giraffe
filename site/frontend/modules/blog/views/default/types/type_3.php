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
    <?php if ($data->contestWork !== null && $this->id != 'contest') $this->renderPartial('application.modules.blog.views.default._contest_post', array('contest' => $data->contestWork->contest)); ?>

    <div class="b-article_in clearfix">
        <div class="wysiwyg-content clearfix">
            <p><?=nl2br(CHtml::encode($data->photoPost->text))?></p>
        </div>
        <?php $this->widget('blog.widgets.PhotoPostWidget', array('post' => $data)); ?>
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
    <?php if ($data->contestWork !== null && $this->id != 'contest') $this->renderPartial('application.modules.blog.views.default._contest_post', array('contest' => $data->contestWork->contest)); ?>

    <div class="b-article_in clearfix">
        <?php //if (!empty($data->preview)):?>
            <div class="wysiwyg-content clearfix">
                <?= $data->purified->preview ?>
            </div>
        <?php //endif ?>
        <?php $this->widget('blog.widgets.PhotoPostWidget', array('post' => $data)); ?>
    </div>

<?php endif ?>