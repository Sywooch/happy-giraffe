<?php
/**
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

<script type="text/javascript">
    $('a[href="#photo-tab-computer"]').tab('show');
</script>

<script type="text/html" id="photo-template">
<div class="i-photo" data-bind="css: cssClass"><a href="" class="ico-close5" data-bind="click: $parent.removePhoto"></a>
    <!-- ko if: status() == PhotoUpload.STATUS_SUCCESS -->
    <div class="i-photo_hold">
        <div class="i-photo_img-hold"><img src="" alt="" class="i-photo_img" data-bind="attr: { src : previewUrl }">
            <div class="i-photo_overlay"><a href="" class="i-photo_rotate"></a><a href="" class="i-photo_rotate i-photo_rotate__r"></a></div>
        </div>
        <input type="text" placeholder="Введите заголовок" class="i-photo_itx itx-gray">
    </div>
    <!-- /ko -->

    <!-- ko if: status() == PhotoUpload.STATUS_LOADING -->
    <div class="i-photo_hold">
        <div class="i-photo_progress">
            <div class="progress progress-striped active progress__cont">
                <div role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%" class="progress-bar progress-bar__cont"></div>
            </div>
            <div class="tx-hint">Загрузка</div>
        </div>
    </div>
    <!-- /ko -->

    <!-- ko if: status() == PhotoUpload.STATUS_FAIL -->
    <div class="i-photo_hold error">
        <div class="tx-hint" data-bind="text: original_name"></div>
        <div class="tx-hint">Ошибка загрузки</div>
    </div>
    <!-- /ko -->
</div>
</script>