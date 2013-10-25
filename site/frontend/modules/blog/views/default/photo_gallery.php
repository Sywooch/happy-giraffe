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
        'windowOptions' => array(
            'exitUrl' => $data->getUrl(),
        ),
    )); ?>
    <div class="textalign-r">
        <a class="b-article_more b-article_more__white" href="javascript:void(0)" onclick="PhotoCollectionViewWidget.open(<?=CJavaScript::encode(get_class($collection))?>, <?=CJavaScript::encode($collection->options)?>, <?=CJavaScript::encode($collection->photoIds[0])?>, <?=CJavaScript::encode(array('exitUrl' => $data->getUrl()))?>)">Смотреть <?=$collection->count?> фото</a>
    </div>
</div>