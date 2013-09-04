<?php
/**
 * @var $data BlogContent
 */
$collection = new PhotoPostPhotoCollection(array('contentId' => $data->id));

?><div class="b-photopost">
    <h2 class="b-photopost_t"><?=CHtml::encode($data->gallery->title) ?></h2>
    <?php $this->widget('PhotoCollectionViewWidget', array(
        'collection' => $collection,
        'width' => 580,
    )); ?>
    <div class="textalign-r">
        <a class="b-article_more b-article_more__white" href="">Смотреть 25 фото</a>
    </div>
</div>