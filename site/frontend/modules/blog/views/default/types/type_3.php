<?php
/**
 * @var $this DefaultController
 * @var $data BlogContent
 * @var $full bool
 */

$post = $data->photoPost;
$collection = new PhotoPostPhotoCollection(array('contentId' => $data->id));
?>
<?php if ($full):?>
    <h2 class="b-article_t">
        <?=$data->title ?>
    </h2>

    <div class="b-article_in clearfix">
        <div class="wysiwyg-content clearfix">
            <p><?=$data->photoPost->purified->text ?></p>
        </div>
        <?php
        $this->widget('PhotoCollectionViewWidget', array(
            'collection' => $collection,
            'width' => 580,
        ));
        ?>
    </div>
<?php else: ?>
    <h2 class="b-article_t">
        <a href="<?=$data->getUrl() ?>" class="b-article_t-a"><?=$data->title ?></a>
    </h2>

    <div class="b-article_in clearfix">
        <div class="wysiwyg-content clearfix">
            <?= $data->preview ?>
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