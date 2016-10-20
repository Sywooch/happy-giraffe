<?php
/**
 * @var bool $toolbarVerticalFixed
 */
?>

<div id="wysiwyg-related">
    <div id="redactor-popup_b-smile" class="display-n">
        <div class="redactor-popup redactor-popup_b-smile">
            <div class="redactor-popup_tale"></div>
            <div class="redactor-popup_t">Вставить смайл</div>
            <table class="redactor-popup_smiles">
                <tbody>
                    <tr>
                        <td><a href=""><img src="/images/widget/smiles-new/emoji_1.gif"></a></td>
                        <td><a href=""><img src="/images/widget/smiles-new/emoji_2.gif"></a></td>
                        <td><a href=""><img src="/images/widget/smiles-new/emoji_3.gif"></a></td>
                        <td><a href=""><img src="/images/widget/smiles-new/emoji_4.gif"></a></td>
                        <td><a href=""><img src="/images/widget/smiles-new/emoji_5.gif"></a></td>
                        <td><a href=""><img src="/images/widget/smiles-new/emoji_6.gif"></a></td>
                        <td><a href=""><img src="/images/widget/smiles-new/emoji_7.gif"></a></td>
                        <td><a href=""><img src="/images/widget/smiles-new/emoji_8.gif"></a></td>
                    </tr>
                    <tr>
                        <td><a href=""><img src="/images/widget/smiles-new/emoji_9.gif"></a></td>
                        <td><a href=""><img src="/images/widget/smiles-new/emoji_10.gif"></a></td>
                        <td><a href=""><img src="/images/widget/smiles-new/emoji_11.gif"></a></td>
                        <td><a href=""><img src="/images/widget/smiles-new/emoji_12.gif"></a></td>
                        <td><a href=""><img src="/images/widget/smiles-new/emoji_13.gif"></a></td>
                        <td><a href=""><img src="/images/widget/smiles-new/emoji_14.gif"></a></td>
                        <td><a href=""><img src="/images/widget/smiles-new/emoji_15.gif"></a></td>
                        <td><a href=""><img src="/images/widget/smiles-new/emoji_16.gif"></a></td>
                    </tr>
                    <tr>
                        <td><a href=""><img src="/images/widget/smiles-new/emoji_17.gif"></a></td>
                        <td><a href=""><img src="/images/widget/smiles-new/emoji_18.gif"></a></td>
                        <td><a href=""><img src="/images/widget/smiles-new/emoji_19.gif"></a></td>
                        <td><a href=""><img src="/images/widget/smiles-new/emoji_20.gif"></a></td>
                        <td><a href=""><img src="/images/widget/smiles-new/emoji_21.gif"></a></td>
                        <td><a href=""><img src="/images/widget/smiles-new/emoji_22.gif"></a></td>
                        <td><a href=""><img src="/images/widget/smiles-new/emoji_23.gif"></a></td>
                        <td><a href=""><img src="/images/widget/smiles-new/emoji_24.gif"></a></td>
                    </tr>
                    <tr>
                        <td><a href=""><img src="/images/widget/smiles-new/emoji_25.gif"></a></td>
                        <td><a href=""><img src="/images/widget/smiles-new/emoji_26.gif"></a></td>
                        <td><a href=""><img src="/images/widget/smiles-new/emoji_27.gif"></a></td>
                        <td><a href=""><img src="/images/widget/smiles-new/emoji_28.gif"></a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div id="redactor-popup_b-video" class="display-n">
        <div class="redactor-popup">
            <div class="redactor-popup_tale"></div>
            <div class="redactor-popup_t">Загрузите видео</div>
            <!-- ko if: embed() === null -->
            <div class="redactor-popup_add-video" data-bind="css: { active : previewLoading() || previewError() }">
                <div class="redactor-popup_add-video-hold">
                    <div class="redactor-popup_video-serv">
                        <div class="redactor-popup_video-serv-tx">Поддерживаемые сервисы:</div>
                        <div class="redactor-popup_video-serv-i redactor-popup_video-serv-i__youtube" data-bind="css: { active : isProvider('youtube') }"></div>
                        <div class="redactor-popup_video-serv-i redactor-popup_video-serv-i__rutube" data-bind="css: { active : isProvider('rutube') }"></div>
                        <div class="redactor-popup_video-serv-i redactor-popup_video-serv-i__vimeo" data-bind="css: { active : isProvider('vimeo') }"></div>
                    </div>
                    <input placeholder="Введите ссылку на видео" class="itx-simple itx-simple__blue w-350 float-l" data-bind="value: link, valueUpdate: ['afterkeydown','propertychange','input']">
                    <button class="btn-green btn-medium" data-bind="css: { 'btn-inactive' : link().length == 0 }, click: check">Загрузить  видео</button>
                </div>
                <div class="redactor-popup_add-video-load" data-bind="visible: previewLoading">
                    <img src="/images/ico/ajax-loader.gif" alt=""><br>Подождите видео загружается
                </div>
                <div class="redactor-popup_add-video-error" data-bind="visible: previewError">
                    <div class="ico-error-smile"></div>Ошибка загрузки видео. Попробуйте вставить другую ссылку
                </div>
            </div>
            <!-- /ko -->
            <!-- ko if: embed() != null -->
            <div class="redactor-popup_video clearfix"><a title="Удалить" class="redactor-popup_video-del ico-close powertip" data-bind="click: remove"></a>
                <div data-bind="html: embed"></div>
            </div>
            <div class="textalign-c margin-t15"><a class="a-pseudo" data-bind="click: remove">Нет, загрузить другой ролик</a><a class="btn-green btn-medium margin-l20" data-bind="click: add">Добавить видео</a></div>
            <!-- /ko -->
        </div>
    </div>

    <div id="redactor-popup_b-photo" class="display-n">
        <div class="redactor-popup">
            <div class="redactor-popup_tale"></div>
            <div class="redactor-popup_t">Загрузите фото</div>
            <div class="redactor_popup_b-photo_content">
                <form id="wysiwygImage2" method="POST" enctype="multipart/form-data">
                    <div class="file-fake powertip" title="Фото">
                        <div class="file-fake_btn redactor_btn_image"></div>
                        <input type="file" class="file-fake_inp" accept="image/*" data-bind="click: photoClick">
                    </div>
                </form>

                <form id="wysiwygImage3" method="POST" enctype="multipart/form-data">
                    <div class="file-fake powertip" title="Камера">
                        <div class="file-fake_btn redactor_btn_image"></div>
                        <input type="file" class="file-fake_inp" accept="image/*" capture="camera" data-bind="click: photoClick">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>