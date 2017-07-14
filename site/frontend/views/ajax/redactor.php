<?php
/**
 * @var bool $toolbarVerticalFixed
 */
?>

<script type="text/javascript" src="/redactor/redactor.js"></script>
<script type="text/javascript" src="/redactor/lang/ru.js"></script>
<script type="text/javascript" src="/redactor/plugins/toolbarVerticalFixed/toolbarVerticalFixed.js"></script>

<div class="wysiwyg-related">
    <div class="redactor-popup redactor-popup__vert-old redactor-popup_b-smile display-n">
<!--        <a href="javascript:void(0)" class="redactor-popup_close ico-close3 powertip" title="Закрыть" onclick="$(this).parents('.redactor-popup').addClass('display-n');"></a>-->
        <table class="redactor-popup_smiles">
            <tbody>
                <tr>
                    <td><a href="javascript:void(0)"><img src="/images/widget/smiles-new/emoji_1.gif"></a></td>
                    <td><a href="javascript:void(0)"><img src="/images/widget/smiles-new/emoji_2.gif"></a></td>
                    <td><a href="javascript:void(0)"><img src="/images/widget/smiles-new/emoji_3.gif"></a></td>
                    <td><a href="javascript:void(0)"><img src="/images/widget/smiles-new/emoji_4.gif"></a></td>
                    <td><a href="javascript:void(0)"><img src="/images/widget/smiles-new/emoji_5.gif"></a></td>
                    <td><a href="javascript:void(0)"><img src="/images/widget/smiles-new/emoji_6.gif"></a></td>
                </tr>
                <tr>
                    <td><a href="javascript:void(0)"><img src="/images/widget/smiles-new/emoji_7.gif"></a></td>
                    <td><a href="javascript:void(0)"><img src="/images/widget/smiles-new/emoji_8.gif"></a></td>
                    <td><a href="javascript:void(0)"><img src="/images/widget/smiles-new/emoji_9.gif"></a></td>
                    <td><a href="javascript:void(0)"><img src="/images/widget/smiles-new/emoji_10.gif"></a></td>
                    <td><a href="javascript:void(0)"><img src="/images/widget/smiles-new/emoji_11.gif"></a></td>
                    <td><a href="javascript:void(0)"><img src="/images/widget/smiles-new/emoji_12.gif"></a></td>
                </tr>
                <tr>
                    <td><a href="javascript:void(0)"><img src="/images/widget/smiles-new/emoji_13.gif"></a></td>
                    <td><a href="javascript:void(0)"><img src="/images/widget/smiles-new/emoji_14.gif"></a></td>
                    <td><a href="javascript:void(0)"><img src="/images/widget/smiles-new/emoji_15.gif"></a></td>
                    <td><a href="javascript:void(0)"><img src="/images/widget/smiles-new/emoji_16.gif"></a></td>
                    <td><a href="javascript:void(0)"><img src="/images/widget/smiles-new/emoji_17.gif"></a></td>
                    <td><a href="javascript:void(0)"><img src="/images/widget/smiles-new/emoji_18.gif"></a></td>
                </tr>
                <tr>
                    <td><a href="javascript:void(0)"><img src="/images/widget/smiles-new/emoji_22.gif"></a></td>
                    <td><a href="javascript:void(0)"><img src="/images/widget/smiles-new/emoji_23.gif"></a></td>
                    <td><a href="javascript:void(0)"><img src="/images/widget/smiles-new/emoji_24.gif"></a></td>
                    <td><a href="javascript:void(0)"><img src="/images/widget/smiles-new/emoji_25.gif"></a></td>
                    <td><a href="javascript:void(0)"><img src="/images/widget/smiles-new/emoji_26.gif"></a></td>
                    <td><a href="javascript:void(0)"><img src="/images/widget/smiles-new/emoji_27.gif"></a></td>
                </tr>
                <tr>
                    <td><a href="javascript:void(0)"><img src="/images/widget/smiles-new/emoji_28.gif"></a></td>
                    <td><a href="javascript:void(0)"><img src="/images/widget/smiles-new/emoji_19.gif"></a></td>
                    <td><a href="javascript:void(0)"><img src="/images/widget/smiles-new/emoji_20.gif"></a></td>
                    <td><a href="javascript:void(0)"><img src="/images/widget/smiles-new/emoji_21.gif"></a></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- ko stopBinding: true -->
    <div class="redactor-popup redactor-popup__vert-old redactor-popup_b-video display-n" id="redactor-popup_b-video">
        <a href="javascript:void(0)" class="redactor-popup_close ico-close3 powertip" title="Закрыть" onclick="$(this).parents('.redactor-popup').addClass('display-n');"></a>
        <div class="redactor-popup_t">Загрузите видео</div>
        <div class="redactor-popup_video clearfix" data-bind="visible: embed() !== null">
            <a class="redactor-popup_video-del ico-close powertip" title="Удалить" data-bind="click: remove"></a>
            <div data-bind="html: embed" id="embed"></div>
        </div>
        <div class="redactor-popup_add-video" data-bind="visible: embed() === null, css: { active : previewLoading() || previewError() }">
            <div class="redactor-popup_add-video-hold">
                <input type="text" class="itx-simple w-350 float-l" placeholder="Введите ссылку на видео" data-bind="value: link, valueUpdate: ['afterkeydown','propertychange','input']">
                <button class="btn-green btn-medium" data-bind="css: { 'btn-inactive' : link().length == 0 }, click: check">Загрузить  видео</button>
            </div>
            <div class="redactor-popup_add-video-load" data-bind="visible: previewLoading">
                <img src="/images/ico/ajax-loader.gif" alt=""> <br>
                Подждите, видео загружается
            </div>
            <div class="redactor-popup_add-video-error" data-bind="visible: previewError">
                Не удалось загрузить видео. <br>
                Возможно, URL указан неправильно либо ведет на неподдерживаемый сайт.
            </div>
        </div>
        <div class="textalign-c margin-t15" data-bind="visible: embed() !== null">
            <a href="javascript:void(0)" class="btn-gray-light btn-medium margin-r10" onclick="$(this).parents('.redactor-popup').addClass('display-n');">Отменить</a>
            <a href="javascript:void(0)" class="btn-green btn-medium" onclick="redactor.selectionRestore(); redactor.insertHtmlAdvanced('<div class=\x22b-article_in-img\x22>' + $('#embed').html() + '</div>'); redactor.sync(); $(this).parents('.redactor-popup').addClass('display-n');">Добавить видео</a>
        </div>
    </div>
    <!-- /ko -->

    <!-- ko stopBinding: true -->
    <div class="redactor-popup redactor-popup__vert-old redactor-popup_b-photo display-n" id="redactor-popup_b-photo">
        <a href="" class="redactor-popup_close ico-close3 powertip" data-bind="click: close"></a>
        <div class="redactor-popup_t">Загрузите фото</div>

        <?php $this->renderPartial('application.views.upload_image_popup'); ?>

        <div class="textalign-c margin-t15">
            <a href="javascript:;" class="btn-gray-light btn-medium margin-r10" onclick="$(this).parents('.redactor-popup').addClass('display-n');">Отменить</a>
            <a href="" class="btn-green btn-medium" data-bind="click: add, css: {'btn-inactive': !upload().addActive()}">Добавить фото</a>
        </div>
    </div>
    <!-- /ko -->

    <!-- ko stopBinding: true -->
    <div class="redactor-popup redactor-popup__vert-old redactor-popup_b-link display-n" id="redactor-popup_b-link">
        <a class="redactor-popup_close ico-close3 powertip" title="Закрыть" data-bind="click: close"></a>
        <div class="redactor-popup_t">Ссылка</div>

        <div class="redactor-popup_holder-blue">
            <div class="margin-b10 clearfix">
                <label class="redactor-popup_label" for="">Отображаемый текст</label>
                <div class="float-l w-350">
                    <input type="text" placeholder="Введите текст" class="itx-simple" data-bind="value: text">
                </div>
            </div>
            <div class="clearfix">
                <label class="redactor-popup_label" for="">Ссылка на</label>
                <div class="float-l w-350">
                    <input type="text" placeholder="Введите URL страницы" class="itx-simple" data-bind="value: url, hasfocus: url().length == 0">
                </div>
            </div>
        </div>

        <div class="textalign-c margin-t15">
            <a class="btn-gray-light btn-medium margin-r10" data-bind="click: close">Отменить</a>
            <a class="btn-green btn-medium" data-bind="click: processLink">Добавить ссылку</a>
        </div>
    </div>
    <!-- /ko -->
</div>