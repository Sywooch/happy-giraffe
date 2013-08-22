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
                            <div class="float-r font-small color-gray" data-bind="length: { attribute : titleValue, maxLength : 50 }"></div>
                        </div>
                        <input type="text" class="popup-blog-set_itx" placeholder="Введите название" data-bind="value: titleValue, valueUpdate: 'keyup', event: { keypress : titleHandler }" maxlength="50">
                        <div class="margin-t5 margin-b10 clearfix">
                            <button class="btn-green float-r" data-bind="click: setTitle">Ok</button>
                        </div>
                        <label for="" class="popup-blog-set_label">Краткое описание</label>
                        <div class="clearfix">
                            <div class="float-r font-small color-gray" data-bind="length: { attribute : descriptionValue, maxLength : 150 }"></div>
                        </div>
                        <textarea class="popup-blog-set_itx" placeholder="Краткое описание" data-bind="value: descriptionValue, valueUpdate: 'keyup'"></textarea>
                        <div class="margin-t5 margin-b10 clearfix">
                            <button class="btn-green float-r" data-bind="click: setDescription">Ok</button>
                        </div>
                    </div>
                    <div class="popup-blog-set_col-wide">
                        <label for="" class="popup-blog-set_label">Название блога</label>
                        <div class="margin-t15 clearfix">
                            <div class="popup-blog-set_jcrop">
                                <img alt="" class="popup-blog-set_jcrop-img" data-bind="attr: { src : draftPhoto().originalSrc() }">
                            </div>
                            <div class="float-l">
                                <div class="margin-b10 clearfix">
                                    <div class="file-fake">
                                        <?=CHtml::beginForm(array('settings/uploadPhoto'), 'post', array('target' => 'upload-target', 'enctype' => 'multipart/form-data'))?>
                                        <button class="btn-green btn-medium file-fake_btn">Загрузить  фото</button>
                                        <input type="file" name="photo" onchange="submit()">
                                        <?=CHtml::endForm()?>
                                    </div>
                                </div>
                                <div class="color-gray font-small">Разрешенные форматы файлов <br> JPG, GIF или  PNG. <br>Максимальный размер 700 Кб. </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="popup-blog-set_sepor">
                    <span class="popup-blog-set_sepor-tx">Так будет выглядеть на странице</span>
                </div>
                <div class="clearfix">
                    <div class="float-r">
                        <div class="blog-title-b">
                            <div class="blog-title-b_img-hold">
                                <img alt="" class="blog-title-b_img" id="preview" data-bind="attr: { src : draftPhoto().originalSrc() }">
                            </div>
                            <h1 class="blog-title-b_t" data-bind="text: title"></h1>
                        </div>
                    </div>
                    <div class="float-l">

                        <div class="aside-blog-desc">
                            <div class="aside-blog-desc_tx" data-bind="html: descriptionToShow"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-box tab-box-2" style="display: none;">
                <div class="b-checkbox margin-b10">
                    <input type="checkbox" id="b-checkbox_label" class="b-checkbox_checkbox">
                    <label for="b-checkbox_label" class="b-checkbox_label">Показывать рубрики на странице блога</label>
                </div>
                <!-- ko foreach: rubrics -->
                <div class="margin-b10 clearfix">
                    <!-- ko if: ! beingEdited() -->
                    <a href="javascript:void(0)" class="popup-blog-set_rubric" data-bind="text: title"></a>
                    <a class="message-ico message-ico__edit" data-bind="click: edit"></a>
                    <a class="message-ico message-ico__del" data-bind="click: remove"></a>
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
        function showPreview(coords)
        {
            position = coords;

            var rx = 720 / coords.w;
            var ry = 128 / coords.h;

            $('#preview').css({
                width: Math.round(rx * blogVM.draftPhoto().width()) + 'px',
                height: Math.round(ry * blogVM.draftPhoto().height()) + 'px',
                marginLeft: '-' + Math.round(rx * coords.x) + 'px',
                marginTop: '-' + Math.round(ry * coords.y) + 'px'
            });
        }

        $(function() {
            ko.applyBindings(blogVM, document.getElementById('popup-blog-set'));
            jcrop_api = null;
            $('.popup-blog-set_jcrop-img').Jcrop({
                setSelect: [ blogVM.photo().position().x, blogVM.photo().position().y, blogVM.photo().position().x2, blogVM.photo().position().y2 ],
                onChange: showPreview,
                onSelect: showPreview,
                aspectRatio: 720 / 128,
                boxWidth: 320
            }, function(){
                jcrop_api = this;
            });

            $('#upload-target').on('load', function() {
                var response = $(this).contents().find('#response').text();
                if (response.length > 0) {
                    blogVM.draftPhoto(new Photo($.parseJSON(response)));
                    jcrop_api.destroy();
                    var x = blogVM.draftPhoto().width()/2 - 720/2;
                    var y = blogVM.draftPhoto().height()/2 - 128/2;
                    var x2 = x + 720;
                    var y2 = y + 128;
                    $('.popup-blog-set_jcrop-img').Jcrop({
                        setSelect: [ x, y, x2, y2 ],
                        onChange: showPreview,
                        onSelect: showPreview,
                        aspectRatio: 720 / 128,
                        boxWidth: 320
                    }, function(){
                        jcrop_api = this;
                    });
                }
            });
        });
    </script>
</div