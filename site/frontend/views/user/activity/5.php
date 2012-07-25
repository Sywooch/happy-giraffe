<?php
    $photosIds = array();
    foreach ($action->data as $photo)
        $photosIds[] = $photo['id'];
    $criteria = new CDbCriteria(array(
        'with' => 'photos',
        'condition' => 't.id = :album_id',
        'params' => array(':album_id' => $action->blockData['album_id']),
    ));
    $criteria->addInCondition('photos.id', $photosIds);
    $album = AlbumPhoto::model()->find($criteria);
?>

<div class="user-albums list-item">

    <div class="box-title">Добавил новые фото</div>

    <div class="added-to"><span>в альбом</span> «<?=CHtml::link($album->title, $album->url)?>»</div>

    <div class="added-date">21 июн 2012, 13:25</div>

    <ul>
        <li><div class="clearfix">
            <div class="preview">
                <?php for($i = 1; $i <= count($album->photos); $i++): ?>
                    <?=CHtml::image($p->getPreviewUrl(180, 180), null, array('class' => 'img-' . $i))?>
                <?php endfor; ?>
            </div>
            <?=CHtml::link('<i class="icon"></i>Смотреть', array('albums/user', 'id' => $this->user->id), array('class' => 'more'))?>
        </div>
        </li>
    </ul>

</div>