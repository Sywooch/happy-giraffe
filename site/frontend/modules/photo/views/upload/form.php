<?php
/**
 * @var $data
 */
?>

<div id="photo-computer-mylti-empty" class="popup popup-add popup-add__photos">
    <button title="Закрыть (Esc)" type="button" class="mfp-close">×</button>
    <div class="popup-add_hold">
        <div class="popup-add_top clearfix">
            <div class="popup-add_t">Добавить фотографии</div>
            <ul class="tabs-simple tabs-simple__inline nav nav-tabs">
                <li class="active"><a href="#photo-tab-computer" data-toggle="tab">С компьютера</a></li>
                <li><a href="#photo-tab-album" data-toggle="tab">Из моих альбомов</a></li>
                <li><a href="#photo-tab-link" data-toggle="tab">Из интернета</a></li>
            </ul>
        </div>
        <div class="popup-add_in tab-content">
            <?php $this->renderPartial('_fromComputer', compact('data')); ?>
            <?php $this->renderPartial('_fromAlbums'); ?>
            <?php $this->renderPartial('_byUrl'); ?>
        </div>
    </div>
</div>