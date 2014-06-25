<div id="photo-tab-link" class="tab-pane active">
    <div class="popup-add_frame">
        <div class="popup-add_cap">
            <!-- cap-empty-->
            <div class="cap-empty cap-empty__addPhotoLink">
                <div class="cap-empty_hold">
                    <div class="cap-empty_img"></div>
                    <div class="cap-empty_t">Выберите файл из интернета</div>
                    <div class="cap-empty_tx"><input type="text" placeholder="Вставте ссылку на изображение" class="itx-gray" data-bind="value: url, valueUpdate: 'input'"></div>
                    <div class="cap-empty_tx-sub">На любом сайте кликните правой кнопкой по нужному изображению, выберите “Копировать URL картинки” и вставте сюда</div>
                </div>
                <div class="verticalalign-m-help"></div>
            </div>
            <!-- /cap-empty-->
        </div>
        <div class="textalign-c" data-bind="template: { name: 'photo-template', if: photo() !== null, data: photo }">

        </div>
    </div>
    <div class="popup-add_footer">
        <div class="textalign-c"><a href="" class="btn btn-success">Добавить</a></div>
    </div>
</div>

<script type="text/javascript">
    url = new ByUrlViewModel(<?=$form->toJSON()?>);
    ko.applyBindings(url, document.getElementById('photo-tab-link'));
</script>