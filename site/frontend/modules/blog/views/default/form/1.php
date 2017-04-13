<?php
/**
 * @var CommunityContent $model
 * @var HActiveRecord $slaveModel
 * @var $json
 */
if (empty($club_id)){
    $action = $model->isNewRecord ? array('/blog/default/save') : array('/blog/default/save', 'id' => $model->id);
}else
    $action = $model->isNewRecord ? array('/community/default/save') : array('/community/default/save', 'id' => $model->id);

$form = $this->beginWidget('site\frontend\components\requirejsHelpers\ActiveForm', array(
    'id' => 'blog-form',
    'action' => $action,
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnType' => true,
        'validationDelay' => 400,
    ),
)); ?>

<?=$form->hiddenField($model, 'type_id')?>
<input type="hidden" name="formKey" value="<?= \site\frontend\components\FormDepartmentModelsControl::getInstance()->createNewFormKey() ?>">

<?php if (true): ?>

    <style>
        .popup-user-add-record{
            width: 720px;
        }
        .wysiwyg-v .wysiwyg-toolbar-btn{
            padding-top: 0;
        }
        @media screen and (max-width: 767px){
            .popup-user-add-record{
                width: 450px;
            }
            .wysiwyg-v .redactor_editor{
                width: 100%;
                min-height: 200px !important;
                margin-left: 0 !important;
            }

            .wysiwyg-v .wysiwyg-toolbar{
                float: none;
            }
            .wysiwyg-v .redactor_toolbar{
                width: 100%;
                padding: 0 !important;
            }
            .wysiwyg-v .redactor_editor:focus{
                margin-left: 0!important;
            }
            .wysiwyg-v .redactor_toolbar li{
                float: none;
                display: inline-block;
                vertical-align: middle;
                margin: 0 15px;
                padding: 0;
            }
            .b-settings-blue{
                padding: 15px;
            }
            .b-settings-blue__article .b-settings-blue_head{
                padding-left: 0;
            }
            .b-settings__header{
                padding: 15px;
            }
        }
        @media screen and (max-width: 480px){
            .popup-user-add-record{
                width: 315px;
            }
        }
    </style>

    <div id="popup-user-add-article" class="popup-user-add-record"><a onclick="$.fancybox.close();" href="javascript:void(0);" title="Закрыть" class="popup-transparent-close popup-transparent-close_mod"></a>
        <div class="clearfix">
            <div class="popup_mod">
                <div class="b-settings__header clearfix">
                    <div class="b-settings__title float-l">Добавить тему</div>
                </div>
                <div class="b-settings-blue b-settings-blue__article b-settings-blue_mod">
                    <div class="b-settings-blue_head">
                        <div class="b-settings-blue_row clearfix">
                            <div class="float-r">
                                <select name="<?=CHtml::activeName($model, 'forum_id')?>" id="<?=CHtml::activeId($model, 'forum_id')?>" data-bind="options: rubricsList,
                value: selectedRubric,
                optionsText: function(rubric) {
                    return rubric.title;
                },
                optionsValue: function(rubric) {
                    return rubric.id;
                },
                select2: {
                    allowClear: true,
                    minimumResultsForSearch: -1,
                    dropdownAutoWidth: true,
                    containerCssClass: 'select-wrapper',
                    dropdownCssClass: 'select-dropdown'
                }" data-placeholder="Выберите подфорум"></select>
                                <?=$form->error($model, 'forum_id')?>
                            </div>
                        </div>
                    </div>
                    <div class="b-settings-blue_head">
                        <div class="b-settings-blue_row clearfix">
                            <div class="float-l f">
                                <?=$form->textField($model, 'title', array('class' => 'itx-simple itx-simple_mod', 'placeholder' => 'Введите заголовок'))?>
                                <?=$form->error($model, 'title')?>
                            </div>
                        </div>
                    </div>
                    <div class="wysiwyg-v wysiwyg-blue clearfix">
                        <?php $slaveModel->text = $slaveModel->forEdit->text ?>
                        <?=$form->textArea($slaveModel, 'text', array('class' => 'wysiwyg-redactor-v'))?>
                        <?=$form->error($slaveModel, 'text')?>
                    </div>
                    <div class="clearfix"><button class="btn-blue btn-h46 float-r btn-inactive">Опубликовать</button></div>
                </div>
            </div>
        </div>
    </div>

<?php endif; ?>

<?php if (false): ?>

<div id="popup-user-add-article" class="b-settings-blue b-settings-blue__article">
    <?php if ($model->isNewRecord): ?>
        <div class="b-settings-blue_tale"></div>
    <?php endif; ?>
    <div class="b-settings-blue_head">
        <div class="b-settings-blue_row clearfix">
            <div class="clearfix">
                <div class="float-r font-small color-gray margin-3" data-bind="length: { attribute : title, maxLength : 50 }"></div>
            </div>
            <?=$form->label($model, 'title', array('class' => 'b-settings-blue_label'))?>
            <div class="w-400 float-l">
                <?=$form->textField($model, 'title', array('class' => 'itx-simple w-400', 'placeholder' => 'Придумайте заголовок', 'data-bind' => 'value: title, valueUpdate: \'keyup\''))?>
                <?=$form->error($model, 'title')?>
            </div>
        </div>
        <?php $this->renderPartial('/default/form/_rubric', array('model' => $model, 'form' => $form, 'club_id' => $club_id)); ?>
    </div>

    <div class="wysiwyg-v wysiwyg-blue clearfix">
        <?php $slaveModel->text = $slaveModel->forEdit->text ?>
        <?=$form->textArea($slaveModel, 'text', array('class' => 'wysiwyg-redactor-v'))?>
        <?=$form->error($slaveModel, 'text')?>
    </div>

    <?php if (!empty($club_id) && Yii::app()->user->checkAccess('editor')): ?>
        <div class="clearfix">
            <div class="row-title"><?= $form->label($model, 'by_happy_giraffe'); ?>:</div>
            <div class="row-elements">
                <?= $form->checkBox($model, 'by_happy_giraffe'); ?>
            </div>
        </div>
    <?php endif; ?>

    <div class=" clearfix">
        <button class="btn-blue btn-h46 float-r"><?=$model->isNewRecord ? 'Добавить' : 'Сохранить'?></button>
        <a href="javascript:void(0)" onclick="$.fancybox.close()" class="btn-gray-light btn-h46 float-r margin-r15">Отменить</a>
    </div>
</div>

<?php endif; ?>

<?php $this->endWidget(); ?>

<?php
/**
 * @var ClientScript $cs
 */
$cs = Yii::app()->clientScript;

$wysiwyg_js = <<<JS
    $('.wysiwyg-redactor-v').redactorHG({
        plugins: ['toolbarVerticalFixed'],
        minHeight: 410,
        autoresize: true,
        buttons: ['bold', 'italic', 'underline', 'deleted', 'h2', 'h3', 'unorderedlist', 'orderedlist', 'link_add', 'link_del', 'image', 'video', 'smile']
    });
JS;

$js = <<<JS
    var BlogFormPostViewModel = function(data) {
        var self = this;
        ko.utils.extend(self, new BlogFormViewModel(data));
    };
JS;
$js .= "ko.applyBindings(new BlogFormPostViewModel(" . CJSON::encode($json) . "), document.getElementById('popup-user-add-article'));";

if ($cs->useAMD) {
    $cs->registerAMD('wysiwyg-old', array('wysiwyg_old' => 'wysiwyg_old'), $wysiwyg_js);
    $cs->registerAMD('add-post', array('ko' => 'knockout', 'ko_post' => 'ko_post'), $js);
} else {
    $cs->registerScript('wysiwyg-old', $wysiwyg_js, ClientScript::POS_READY);
    $cs->registerScript('add-post', $js, ClientScript::POS_READY);
}
?>