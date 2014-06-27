<?php
/**
 * @var $this site\frontend\modules\photo\controllers\UploadController
 * @var $form site\frontend\modules\photo\models\upload\PopupForm
 */
?>

<div id="photo-computer-mylti-empty" class="popup popup-add popup-add__photos">
    <button title="Закрыть (Esc)" type="button" class="mfp-close">×</button>
    <div class="popup-add_hold">
        <div class="popup-add_top clearfix">
            <div class="popup-add_t">Добавить фотографии</div>
            <ul class="tabs-simple tabs-simple__inline nav nav-tabs">
                <li><a href="#photo-tab-computer" data-toggle="tab">С компьютера</a></li>
                <li><a href="#photo-tab-album" data-toggle="tab">Из моих альбомов</a></li>
                <li><a href="#photo-tab-link" data-toggle="tab">Из интернета</a></li>
            </ul>
        </div>
        <div class="popup-add_in tab-content">
            <?php $this->renderPartial('_fromComputer', compact('form')); ?>
            <?php $this->renderPartial('_fromAlbums', compact('form')); ?>
            <?php $this->renderPartial('_byUrl', compact('form')); ?>
        </div>
    </div>
</div>

<?php $this->renderPartial('_photo'); ?>

<script type="text/javascript">
    $('a[href="#photo-tab-computer"]').tab('show');
</script>