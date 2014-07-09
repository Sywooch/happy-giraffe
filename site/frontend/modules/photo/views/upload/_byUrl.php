<?php
/**
 * @var $form site\frontend\modules\photo\models\upload\PopupForm
 */
?>

<div id="photo-tab-link" class="tab-pane">
    <div class="popup-add_frame">
        <div class="popup-add_cap">
            <div class="cap-empty cap-empty__addPhotoLink">
                <div class="cap-empty_hold">
                    <div class="cap-empty_img"></div>
                    <div class="cap-empty_t">Выберите файл из интернета</div>
                    <div class="cap-empty_tx"><input type="text" placeholder="Вставте ссылку на изображение" class="itx-gray" data-bind="value: url, valueUpdate: 'input'"></div>
                    <div class="cap-empty_tx-sub">На любом сайте кликните правой кнопкой по нужному изображению, выберите “Копировать URL картинки” и вставьте сюда</div>
                </div>
                <div class="verticalalign-m-help"></div>
            </div>
        </div>
        <div class="textalign-c" data-bind="template: { name: 'photo-template', if: photo() !== null, data: photo }">

        </div>
    </div>
    <div class="popup-add_footer" data-bind="visible: photo() !== null">
        <div class="textalign-c"><button href="" class="btn btn-success" data-bind="disable: loading, click: add">Добавить</button></div>
    </div>
</div>

<script type="text/javascript">
    require(['knockout', 'ko_photo'], function(ko) {
        ko.applyBindings(new ByUrlViewModel(<?=$form->output()?>), document.getElementById('photo-tab-link'));
    });
</script>