<?php
/**
 * @var $form site\frontend\modules\photo\models\upload\PopupForm
 */
?>

<div id="photo-tab-computer" class="tab-pane active">
    <div class="popup-add_frame">
        <div class="popup-add_cap">
            <!-- cap-empty-->
            <div class="cap-empty cap-empty__addPhoto">
                <div class="cap-empty_hold">
                    <div class="cap-empty_img"></div>
                    <div class="cap-empty_t">Выберите файл с компьютера</div>
                    <div class="cap-empty_tx-sub"><div class='file-fake'><div class='btn btn-s btn-primary file-fake_btn'>Обзор</div><input type='file' class='file-fake_inp' data-bind="fileUpload: { options : fileUploadSettings, multiple : false }"></div> <div class='popup-add_cap-desc'>Разрешенные форматы файлов JPG, GIF, PNG.<br> Максимальный размер 700 Kб.</div></div>
                </div>
                <div class="verticalalign-m-help"></div>
            </div>
            <!-- /cap-empty-->
        </div>
        <div class="textalign-c" data-bind="template: { name: 'photo-template', if: photo() !== null, data: photo }">

        </div>
    </div>
    <div class="popup-add_footer" data-bind="visible: photo() !== null">
        <div class="textalign-c"><a href="" class="btn btn-success">Добавить</a></div>
    </div>
</div>

<script type="text/javascript">
    uploadVM = new FromComputerSingleViewModel(<?=$form->toJSON()?>);
    ko.applyBindings(uploadVM, document.getElementById('photo-tab-computer'));
</script>