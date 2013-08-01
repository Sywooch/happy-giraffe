<?php
/**
 * @var CommunityContent $model
 * @var HActiveRecord $slaveModel
 * @var $json
 */
?>

<?php $this->renderPartial('form/script'); ?>

<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'blog-form',
    'action' => $model->isNewRecord ? array('save') : array('save', 'id' => $model->id),
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
)); ?>

<?=$form->hiddenField($model, 'type_id')?>

<div id="popup-user-add-article" class="b-settings-blue b-settings-blue__article">
    <div class="b-settings-blue_tale"></div>
    <div class="b-settings-blue_head">
        <div class="b-settings-blue_row clearfix">
            <div class="clearfix">
                <div class="float-r font-small color-gray margin-3" data-bind="length: { attribute : title, maxLength : 50 }"></div>
            </div>
            <?=$form->label($model, 'title', array('class' => 'b-settings-blue_label'))?>
            <?=$form->textField($model, 'title', array('class' => 'itx-simple w-400', 'placeholder' => 'Введите заголовок статьи', 'data-bind' => 'value: title, valueUpdate: \'keyup\''))?>
            <?=$form->error($model, 'title')?>
        </div>
        <div class="b-settings-blue_row clearfix">
            <label for="" class="b-settings-blue_label">Рубрика</label>
            <div class="w-400 float-l">
                <div class="chzn-itx-simple">
                    <?php if(false): ?>
                    <?=$form->dropDownList($model, 'rubric_id', CHtml::listData($this->user->blog_rubrics, 'id', 'title'), array('class' => 'chzn'))?>
                    <?php endif; ?>
                    <select name="<?=CHtml::activeName($model, 'rubric_id')?>" id="<?=CHtml::activeId($model, 'rubric_id')?>" data-bind="options: rubricsList,
                    value: selectedRubric,
                    optionsText: function(rubric) {
                        return rubric.title;
                    },
                    optionsValue: function(rubric) {
                        return rubric.id;
                    },
                    chosen: {}"></select>
                    <?=$form->error($model, 'rubric_id')?>
                </div>
            </div>
        </div>
    </div>

    <div class="wysiwyg-v wysiwyg-blue clearfix">
        <?=$form->textArea($slaveModel, 'text', array('class' => 'wysiwyg-redactor-v'))?>
        <?=$form->error($slaveModel, 'text')?>

        <div class="redactor-popup redactor-popup_b-smile display-n">
            <a href="javascript:void(0)" class="redactor-popup_close ico-close3 powertip" title="Закрыть" onclick="$(this).parents('.redactor-popup').addClass('display-n');"></a>
            <div class="redactor-popup_tale"></div>
            <div class="redactor-popup_t">Выберите смайл</div>
            <table class="redactor-popup_smiles">
                <tbody>
                <tr>
                    <td><a href=""><img src="/images/widget/smiles/acute (1).gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/acute.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/air_kiss.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/angel.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/bad.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/beach.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/beee.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/blush2.gif"></a></td>
                </tr>
                <tr>
                    <td><a href=""><img src="/images/widget/smiles/Cherna-girl_on_weight.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/connie_1.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/connie_33.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/connie_36.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/connie_6.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/connie_feedbaby.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/cray.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/dance.gif"></a></td>
                </tr>
                <tr>
                    <td><a href=""><img src="/images/widget/smiles/dash2.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/diablo.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/dirol.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/dntknw.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/drinks.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/d_coffee.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/d_lovers.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/facepalm.gif"></a></td>
                </tr>
                <tr>
                    <td><a href=""><img src="/images/widget/smiles/fie.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/first_move.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/fool.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/girl_cray2.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/girl_dance.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/girl_drink1.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/girl_hospital.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/girl_prepare_fish.gif"></a></td>
                </tr>
                <tr>
                    <td><a href=""><img src="/images/widget/smiles/girl_sigh.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/girl_wink.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/girl_witch.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/give_rose.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/good.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/help.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/JC_hiya.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/JC_hulahoop-girl.gif"></a></td>
                </tr>
                <tr>
                    <td><a href=""><img src="/images/widget/smiles/kirtsun_05.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/kuzya_01.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/LaieA_052.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/Laie_16.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/Laie_50.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/Laie_7.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/lazy2.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/l_moto.gif"></a></td>
                </tr>
                <tr>
                    <td><a href=""><img src="/images/widget/smiles/mail1.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/Mauridia_21.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/mosking.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/music2.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/negative.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/pardon.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/phil_05.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/phil_35.gif"></a></td>
                </tr>
                <tr>
                    <td><a href=""><img src="/images/widget/smiles/popcorm1.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/preved.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/rofl.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/sad.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/scratch_one-s_head.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/secret.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/shok.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/smile3.gif"></a></td>
                </tr>
                <tr>
                    <td><a href=""><img src="/images/widget/smiles/sorry.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/tease.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/to_become_senile.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/viannen_10.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/wacko2.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/wink.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/yahoo.gif"></a></td>
                    <td><a href=""><img src="/images/widget/smiles/yes3.gif"></a></td>
                </tr>
                </tbody>
            </table>
        </div>

        <!-- ko stopBinding: true -->
        <div class="redactor-popup redactor-popup_b-video display-n" id="redactor-popup_b-video">
            <a href="javascript:void(0)" class="redactor-popup_close ico-close3 powertip" title="Закрыть" onclick="$(this).parents('.redactor-popup').addClass('display-n');"></a>
            <div class="redactor-popup_tale"></div>
            <div class="redactor-popup_t">Загрузите видео</div>
            <div class="redactor-popup_video clearfix" data-bind="visible: embed() !== null">
                <a class="redactor-popup_video-del ico-close powertip" title="Удалить" data-bind="click: remove"></a>
                <div data-bind="html: embed" id="embed"></div>
            </div>
            <div class="redactor-popup_add-video" data-bind="visible: embed() === null, css: { active : previewLoading() || previewError() }">
                <div class="redactor-popup_add-video-hold">
                    <input type="text" class="itx-simple w-350 float-l" placeholder="Введите ссылку на видео" data-bind="value: link, valueUpdate: 'keyup'">
                    <button class="btn-green btn-medium" data-bind="css: { 'btn-inactive' : link().length == 0 }, click: check">Загрузить  видео</button>
                </div>
                <div class="redactor-popup_add-video-load" data-bind="visible: previewLoading">
                    <img src="/images/ico/ajax-loader.gif" alt=""> <br>
                    Подждите видео загружается
                </div>
                <div class="redactor-popup_add-video-error" data-bind="visible: previewError">
                    Не удалось загрузить видео. <br>
                    Возможно, URL указан неправильно либо ведет на неподдерживаемый сайт.
                </div>
            </div>
            <div class="textalign-c margin-t15" data-bind="visible: embed() !== null">
                <a href="javascript:void(0)" class="btn-gray-light btn-medium margin-r10" onclick="$(this).parents('.redactor-popup').addClass('display-n');">Отменить</a>
                <a href="javascript:void(0)" class="btn-green btn-medium" onclick="redactor.insertHtml($('#embed').html()); $(this).parents('.redactor-popup').addClass('display-n');">Добавить видео</a>
            </div>
        </div>
        <!-- /ko -->

        <!-- ko stopBinding: true -->
        <div class="redactor-popup redactor-popup_b-photo display-n" id="redactor-popup_b-photo">
            <a href="" class="redactor-popup_close ico-close3 powertip" data-bind="click: close"></a>
            <div class="redactor-popup_tale"></div>
            <div class="redactor-popup_t">Загрузите фото</div>
            <!-- .dragover - класс добавлять, когда курсер мыши с файлами находится над блоком -->
            <div class="b-add-img b-add-img__for-single">
                <div class="b-add-img_hold">
                    <div class="b-add-img_t">
                        Загрузите фотографии с компьютера
                        <div class="b-add-img_t-tx">Поддерживаемые форматы: jpg и png</div>
                    </div>
                    <div class="file-fake">
                        <button class="btn-green btn-medium file-fake_btn">Обзор</button>
                        <input type="file" class="js-upload-files-multiple">
                    </div>
                </div>
                <div class="textalign-c clearfix">
                    <!-- ko with: upload -->
                    <!-- ko foreach: photos -->
                    <div class="b-add-img_i" data-bind="attr: {id: 'uploaded_photo_' + uid}" style="overflow: hidden;">
                        <div class="js-image" style="opacity: 0.2"></div>
                        <div class="b-add-img_i-vert"></div>
                        <div class="b-add-img_i-load">
                            <div class="b-add-img_i-load-progress" data-bind="style: {width: progress}"></div>
                        </div>
                        <div class="b-add-img_i-overlay">
                            <a href="" class="b-add-img_i-del ico-close4" data-bind="click: remove"></a>
                        </div>
                    </div>
                    <!-- /ko -->
                    <!-- /ko -->
                </div>
                <!-- ko if: upload().photos().length == 0 -->
                <div class="b-add-img_html5-tx">или перетащите фото сюда</div>
                <!-- /ko -->
            </div>
            <div class="textalign-c margin-t15">
                <a href="javascript:;" class="btn-gray-light btn-medium margin-r10" onclick="$(this).parents('.redactor-popup').addClass('display-n');">Отменить</a>
                <a href="" class="btn-green btn-medium" data-bind="click: add, css: {'btn-inactive': upload().photos().length == 0}">Добавить фото</a>
            </div>
        </div>
        <!-- /ko -->
    </div>

    <div class=" clearfix">
        <a href="javascript:void(0)" onclick="$('#blog-form').submit()" class="btn-blue btn-h46 float-r"><?=$model->isNewRecord ? 'Добавить' : 'Редактировать'?></a>
        <a href="javascript:void(0)" onclick="$.fancybox.close()" class="btn-gray-light btn-h46 float-r margin-r15">Отменить</a>

        <div class="float-l">
            <div class="privacy-select clearfix">
                <?=$form->hiddenField($model, 'privacy', array('data-bind' => 'value: selectedPrivacyOption().value()'))?>
                <div class="privacy-select_hold clearfix">
                    <div class="privacy-select_tx">Для кого:</div>
                    <div class="privacy-select_drop-hold">
                        <a class="privacy-select_a" data-bind="click: $root.toggleDropdown, with: selectedPrivacyOption()">
                            <span class="ico-users active" data-bind="css: 'ico-users__' + cssClass()"></span>
                            <span class="privacy-select_a-tx" data-bind="html: title"></span>
                        </a>
                    </div>
                    <div class="privacy-select_drop" data-bind="css: { 'display-b' : showDropdown}">
                        <!-- ko foreach: privacyOptions -->
                        <div class="privacy-select_i">
                            <a class="privacy-select_a" data-bind="click: select">
                                <span class="ico-users" data-bind="css: 'ico-users__' + cssClass()"></span>
                                <span class="privacy-select_a-tx" data-bind="html: title"></span>
                            </a>
                        </div>
                        <!-- /ko -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>

<script>
    var BlogFormPostViewModel = function(data) {
        var self = this;
        ko.utils.extend(self, new BlogFormViewModel(data));
    }

    formVM = new BlogFormPostViewModel(<?=CJSON::encode($json)?>);
    ko.applyBindings(formVM, document.getElementById('popup-user-add-article'));
</script>