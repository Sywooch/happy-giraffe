<?php
    $photosIds = array();
    foreach ($action->data as $photo)
        $photosIds[] = $photo['id'];
    $criteria = new CDbCriteria(array(
        'with' => array(
            'photos' => array(
                'alias' => 'selectedPhotos',
            ),
            'photos' => array(
                'alias' => 'allPhotos'
            )
        ),
        'condition' => 't.id = :album_id',
        'params' => array(':album_id' => $action->blockData['album_id']),
    ));
    $criteria->addInCondition('selectedPhotos.id', $photosIds);
    $album = Album::model()->find($criteria);

var_dump(count($album->selectedPhotos));
die;
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
            <?=CHtml::link('<i class="icon"></i>Смотреть', array('albums/user', 'id' => $this->user->id), array('class' => 'more'))?>
        </div>
        </li>
    </ul>

</div>