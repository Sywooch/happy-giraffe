<div id="photo-widget" class="popup-user-add-record">
    <a class="popup-transparent-close" onclick="$.fancybox.close();" href="javascript:void(0);" title="Закрыть"></a>
    <div class="clearfix">
        <div class="w-720 float-r">
            <div class="b-settings-blue b-settings-blue__photo-widget">
                <div class="b-settings-blue_head">
                    <div class="b-settings-blue_row clearfix">
                        <label for="" class="b-settings-blue_label">Название виджета</label>
                        <div class="w-400 float-l">
                            <input type="text" class="itx-simple" data-bind="value: title">
                        </div>
                    </div>
                </div>
                <div class="textalign-c clearfix margin-b10">
                    <div class="b-settings-blue_label float-n w-100p">Выберите главное фото для виджета</div>
                </div>
                <div class="b-add-img b-add-img__for-multi">
                    <div class="textalign-c padding-t20 clearfix">
                        <!-- ko foreach: photos -->
                        <div class="b-add-img_i" data-bind="css: { 'b-add-img_i__check' : isChecked }">
                            <img class="b-add-img_i-img" alt="" data-bind="attr: { src : url }">
                            <div class="b-add-img_i-vert"></div>
                            <div class="b-add-img_i-overlay">
                                <a class="b-add-img_i-check a-checkbox" data-bind="click: setPhoto, css: { active : isChecked }"></a>
                            </div>
                            <div class="b-add-img_i-overlay-b" data-bind="visible: isChecked"></div>
                            <div class="b-add-img_i-marked" data-bind="visible: isChecked"></div>
                        </div>
                        <!-- /ko -->
                    </div>
                </div>
                <div class="b-settings-blue_head">
                    <div class="b-settings-blue_row clearfix">
                        <a class="a-checkbox" data-bind="click: toggleHidden, css: { active : hidden }"></a> <span class="color-gray">- скрыть виджет</span>
                        <!-- <label for="" class="b-settings-blue_label">Название виджета</label>
                        <div class="w-400 float-l">
                            <input type="text" name="" id="" class="itx-simple" value="Самое лучшее утро - просыпаюсь, а ты рядом">
                        </div> -->
                    </div>
                </div>
                <div class="textalign-c clearfix">
                    <a href="javascript:void(0)" class="btn-gray-light btn-h46 margin-r15" onclick="$.fancybox.close();">Отменить</a>
                    <a class="btn-blue btn-h46" data-bind="click: save">Сохранить</a>

                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function() {
        photoWidgetVM = new PhotoWidgetViewModel(<?=CJSON::encode($json)?>);
        ko.applyBindings(photoWidgetVM, document.getElementById('photo-widget'));
    });
</script>