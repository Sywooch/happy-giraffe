<?php
    $photosIds = array();
    foreach ($action->data as $photo)
        $photosIds[] = $photo['id'];
    $criteria = new CDbCriteria(array(
        'with' => array('photos', 'photoCount'),
        'condition' => 't.id = :album_id',
        'params' => array(':album_id' => $action->blockData['album_id']),
    ));
    $criteria->addInCondition('photos.id', $photosIds);
    $album = Album::model()->find($criteria);
?>

<div class="user-albums list-item">

    <div class="box-title">Добавил новые фото</div>

    <div class="added-to"><span>в альбом</span> «<?=CHtml::link($album->title, $album->url)?>»</div>

    <div class="added-date"><?=Yii::app()->dateFormatter->format("dd MMMM yyyy, HH:mm", end(array_values($album->photos))->created)?></div>

    <ul>
        <li><div class="clearfix">
            <div class="preview">
                <?php $i = 0; foreach ($album->photos as $p): ?>
                    <?=CHtml::image($p->getPreviewUrl(180, 180), null, array('class' => 'img-' . ++$i ))?>
                <?php endforeach; ?>
            </div>
            <?php $label = ($album->photoCount > count($album->photos)) ? 'еще ' . ($album->photoCount - count($album->photos)) . ' фото' : 'Смотреть' ?>
            <?=CHtml::link('<i class="icon"></i>' . $label, array('albums/user', 'id' => $this->user->id), array('class' => 'more'))?>
        </div>
        </li>
    </ul>

</div>