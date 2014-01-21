<?php
/**
 * @var ContestWork $work
 * @var ContestPhotoCollection $collection
 */
?>

<div class="contest-participant">
    <div class="contest-participant_t">Моя работа в конкурсе</div>
    <div class="img">
        <div class="clearfix">
            <div class="position">
                <strong><?=$work->getPosition()?></strong> место
            </div>
            <div class="ball">
                <div class="ball-count"><?=$work->rate?></div>
                <div class="ball-text">баллов</div>
            </div>
        </div>
        <a href="javascript:void(0)" onclick="PhotoCollectionViewWidget.open(<?=CJavaScript::encode(get_class($collection))?>, <?=CJavaScript::encode($collection->options)?>, <?=CJavaScript::encode($work->photoAttach->photo->id)?>)">
            <?=CHtml::image($work->photoAttach->photo->getPreviewUrl(210, null, Image::WIDTH))?>
            <span class="btn">Посмотреть</span>
        </a>
        <div class="item-title"><?=$work->title?></div>
    </div>
</div>