<div id="popup-blog-set" class="popup-blog-set">
    <a class="popup-blog-set_close powertip" onclick="$.fancybox.close();" href="javascript:void(0);" title="Закрыть"></a>

    <div class="tabs tabs-white">
        <div class="tabs-white_nav clearfix">
            <ul class="tabs-white_nav-ul">
                <li class="tabs-white_nav-i active">
                    <a onclick="setTab(this, 1);" href="javascript:void(0);" class="tabs-white_nav-a">Оформление </a>
                </li>
                <li class="tabs-white_nav-i">
                    <a onclick="setTab(this, 2);" href="javascript:void(0);"  class="tabs-white_nav-a">Рубрики</a>
                </li>
            </ul>
        </div>

        <div class="tabs-white_cont clearfix">
            <div style="display: block;" class="tab-box tab-box-1">
                <div class="clearfix">
                    <div class="popup-blog-set_col-narrow">
                        <label for="" class="popup-blog-set_label">Название блога</label>
                        <div class="clearfix">
                            <div class="float-r font-small color-gray" data-bind="length: { attribute : draftTitleValue, maxLength : 50 }"></div>
                        </div>
                        <input type="text" class="popup-blog-set_itx" placeholder="Введите название" data-bind="value: draftTitleValue, valueUpdate: 'keyup', event: { keypress : titleHandler }" maxlength="50">
                        <div class="margin-t5 margin-b10 clearfix">
                            <button class="btn-green float-r" data-bind="click: setTitle">Ok</button>
                        </div>
                        <label for="" class="popup-blog-set_label">Краткое описание</label>
                        <div class="clearfix">
                            <div class="float-r font-small color-gray" data-bind="length: { attribute : draftDescriptionValue, maxLength : 150 }"></div>
                        </div>
                        <textarea class="popup-blog-set_itx" placeholder="Введите описание блога" data-bind="value: draftDescriptionValue, valueUpdate: 'keyup'" maxlength="150" rows="3"></textarea>
                        <div class="margin-t5 margin-b10 clearfix">
                            <button class="btn-green float-r" data-bind="click: setDescription">Ok</button>
                        </div>
                    </div>
                    <div class="popup-blog-set_col-wide">
                        <label for="" class="popup-blog-set_label">Выберите фон</label>
                        <div class="b-add-img b-add-img__for-single">
                            <div class="b-add-img_hold" data-bind="visible: draftPhoto() === null">
                                <div class="b-add-img_t">
                                    Загрузите фотографию с компьютера
                                    <div class="b-add-img_t-tx">Поддерживаемые форматы: jpg и png</div>
                                </div>
                                <div class="file-fake">
                                    <button class="btn-green btn-medium file-fake_btn">Обзор</button>
                                    <input class="js-upload-files-multiple" type="file">
                                </div>
                            </div>
                            <!-- ko if: draftPhoto() !== null -->
                            <div class="popup-blog-set_jcrop">
                                <img alt=""  class="popup-blog-set_jcrop-img" data-bind="attr: { src : draftPhoto().originalSrc() }">
                            </div>
                            <a class="b-add-img_i-del ico-close2 powertip" data-bind="click: removeDraftPhoto"></a>
                            <!-- /ko -->
                        </div>
                    </div>
                </div>
                <div class="popup-blog-set_sepor">
                    <span class="popup-blog-set_sepor-tx">Так будет выглядеть ваш блог</span>
                </div>
                <div class="clearfix">
                    <div class="float-r">
                        <div class="blog-title-b">
                            <div class="blog-title-b_img-hold" data-bind="if: draftPhoto() !== null">
                                <img alt="" class="blog-title-b_img" id="preview" data-bind="attr: { src : draftPhoto().originalSrc() }">
                            </div>
                            <h1 class="blog-title-b_t" data-bind="text: draftTitle, visible: draftTitle().length > 0"></h1>
                        </div>
                    </div>
                    <div class="float-l">

                        <div class="aside-blog-desc" data-bind="visible: draftDescriptionToShow().length > 0">
                            <div class="aside-blog-desc_tx" data-bind="html: draftDescriptionToShow"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-box tab-box-2" style="display: none;">
                <div class="b-checkbox margin-b10">
                    <input type="checkbox" id="b-checkbox_label" class="b-checkbox_checkbox" data-bind="checked: showRubricsValue">
                    <label for="b-checkbox_label" class="b-checkbox_label">Показывать рубрики на странице блога</label>
                </div>
                <!-- ko foreach: rubrics -->
                <div class="margin-b10 clearfix">
                    <!-- ko if: ! beingEdited() -->
                    <span class="popup-blog-set_rubric" data-bind="text: title, css: { 'color-gray' : isRemoved }"></span>
                        <!-- ko if: ! isRemoved() -->
                            <a class="message-ico message-ico__edit" data-bind="click: edit"></a>
                            <a class="message-ico message-ico__del" data-bind="click: remove"></a>
                        <!-- /ko -->
                        <!-- ko if: isRemoved -->
                            <a class="font-small a-pseudo" data-bind="click: restore">Восстановить</a>
                        <!-- /ko -->
                    <!-- /ko -->
                    <!-- ko if: beingEdited -->
                    <div class="clearfix w-400">
                        <div class="float-r font-small color-gray" data-bind="length: { attribute : editedTitle, maxLength : 50 }"></div>
                    </div>
                    <div class="float-l margin-r10">
                        <div class="w-400">
                            <input type="text" class="popup-blog-set_itx" placeholder="Введите название рубрики" data-bind="value: editedTitle, valueUpdate: 'keyup', event: { keypress : titleHandler }" maxlength="50">
                        </div>
                    </div>
                    <a class="btn-green  margin-t5" data-bind="click: save">Ok</a>
                    <!-- /ko -->
                </div>
                <!-- /ko -->
                <div class="margin-b10 clearfix">
                    <a class="btn-green btn-medium" data-bind="click: addRubric">Добавить рубрику</a>
                </div>
            </div>
        </div>

        <div class="margin-r20 clearfix">
            <a class="btn-blue btn-h46 float-r" data-bind="click: save">Сохранить</a>
            <a href="javascript:void(0)" onclick="$.fancybox.close()" class="btn-gray-light btn-h46 float-r margin-r15">Отменить</a>
        </div>

    </div>

    <iframe name="upload-target" id="upload-target" style="display: none;"></iframe>

    <script type="text/javascript">
//        function showPreview(coords)
//        {
//            position = coords;
//
//            var rx = 720 / coords.w;
//            var ry = 128 / coords.h;
//
//            $('#preview').css({
//                width: Math.round(rx * blogVM.draftPhoto().width()) + 'px',
//                height: Math.round(ry * blogVM.draftPhoto().height()) + 'px',
//                marginLeft: '-' + Math.round(rx * coords.x) + 'px',
//                marginTop: '-' + Math.round(ry * coords.y) + 'px'
//            });
//        }

        $(function() {
            ko.applyBindings(blogVM, document.getElementById('popup-blog-set'));
            blogVM.initSettings();
        });
    </script>
</div