<?php
/**
 * @var $json
 */
?>

<div id="popup-blog-set" class="popup-blog-set popup-blue">
    <a class="popup-blue_close powertip" onclick="$.fancybox.close();" href="javascript:void(0);" title="Закрыть"></a>

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
                        <input type="text" class="itx-gray" placeholder="Введите название" data-bind="value: titleValue, valueUpdate: 'keyup', event: { keypress : titleHandler }" maxlength="50">
                        <div class="margin-t5 margin-b10 clearfix">
                            <button class="btn-green float-r" data-bind="click: setTitle">Ok</button>
                        </div>
                        <label for="" class="popup-blog-set_label">Краткое описание</label>
                        <div class="clearfix">
                            <div class="float-r font-small color-gray" data-bind="length: { attribute : descriptionValue, maxLength : 150 }"></div>
                        </div>
                        <textarea class="itx-gray" placeholder="Краткое описание" data-bind="value: descriptionValue, valueUpdate: 'keyup'"></textarea>
                        <div class="margin-t5 margin-b10 clearfix">
                            <button class="btn-green float-r" data-bind="click: setDescription">Ok</button>
                        </div>
                    </div>
                    <div class="popup-blog-set_col-wide">
                        <label for="" class="popup-blog-set_label">Название блога</label>
                        <div class="margin-t15 clearfix">
                            <div class="popup-blog-set_jcrop">
                                <img src="/images/jcrop-blog.jpg" alt=""  class="popup-blog-set_jcrop-img" width='300' height='270'>
                            </div>
                            <div class="float-l">
                                <div class="margin-b10 clearfix">
                                    <div class="file-fake">
                                        <button class="btn-green btn-medium file-fake_btn">Загрузить  фото</button>
                                        <input type="file" name="">
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
                                <img src="/images/blog-title-b_img.jpg" alt="" class="blog-title-b_img">
                            </div>
                            <h1 class="blog-title-b_t" data-bind="text: title"></h1>
                        </div>
                    </div>
                    <div class="float-l">

                        <div class="aside-blog-desc">
                            <div class="aside-blog-desc_tx" data-bind="html: description"></div>
                        </div>
                    </div>
                </div>

                <div class="popup-blog-set_sepor margin-b15"></div>
                <div class="margin-b5 clearfix">
                    <a class="btn-blue btn-h46 float-r" data-bind="click: save">Сохранить</a>
                    <a href="javascript:void(0)" onclick="$.fancybox.close()" class="btn-gray-light btn-h46 float-r margin-r15">Отменить</a>
                </div>
            </div>

            <div class="tab-box tab-box-2" style="display: none;">
                56756757
            </div>
        </div>

    </div>

    <script type="text/javascript">
        ko.applyBindings(new BlogSettingsViewModel(<?=CJSON::encode($json)?>), document.getElementById('popup-blog-set'));
    </script>
</div