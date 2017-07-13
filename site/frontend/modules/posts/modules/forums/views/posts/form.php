<?php
/**
 * @var CommunityContent $model
 * @var HActiveRecord $slaveModel
 * @var $json
 */

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
));

?>

<?=$form->hiddenField($model, 'type_id')?>
<input type="hidden" name="formKey" value="<?= \site\frontend\components\FormDepartmentModelsControl::getInstance()->createNewFormKey() ?>">

<div id="add-article">
    <!-- ko if: inited() -->
    <div style="display:none" data-bind="visible: inited()">
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
                            containerCssClass: '',
                            dropdownCssClass: 'select-dropdown'
                        }" data-placeholder="Выберите подфорум">
                    </select>
                    <?=$form->error($model, 'forum_id')?>
                </div>
            </div>
        </div>
        <div class="add-question__panel">
            <div class="b-popup-form__panel">
                <div class="input-field">
                    <?php echo $form->textField($model, 'title', ['class' => 'material-theme', 'id' => 'theme']); ?>
                    <label for="theme">Заголовок записи</label>
                </div>
                <?php echo $form->error($model, 'title'); ?>
            </div>
        </div>
        <div class="add-question__panel">
            <div class="b-redactor">
                <div class="b-redactor__head-toolbar b-redactor__head-toolbar--grey js-stiky-redactor">
                    <div id="redactor-post-toolbar2"></div>
                </div>
                <div class="b-redactor__action b-margin--bottom_10">
                        <?php $slaveModel->text = $slaveModel->forEdit->text; ?>

                        <?php echo $form->textArea($slaveModel, 'text', ['class' => 'b-redactor__textarea', 'placeholder' => 'Введите текст', 
                            'data-bind' => "wswgHG: { 
                                config: {
                                    minHeight: 266,
                                    plugins: ['text', 'imageCustom', 'videoModal', 'smilesModal'],
                                    toolbarExternal: '#redactor-post-toolbar2',
                                    placeholder: 'Введите ваш вопрос',
                                    focus: true,
                                    callbacks: {} 
                                }, 
                                attr: postText
                            }"
                        ]); ?>
                </div>
                <div class="b-redactor__footer b-redactor--theme-right">
                    <div class="b-redactor-footer__item">
                        <button class="btn btn--default btn--lg" data-bind="text: postIsNew() ? 'Опубликовать' : 'Сохранить'">Опубликовать</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- /ko -->
    <!-- ko if: !inited() -->
    <div class="preloader">
        <div class="preloader__inner">
            <div class="preloader__box"><span class="preloader__ico preloader__ico--xl"></span>
            </div><span class="preloader__text">Загрузка</span>
        </div>
    </div>
    <!-- /ko -->
</div>

<?php $this->endWidget(); ?>

<?php

$cs = \Yii::app()->clientScript;

$js = <<<JS
    var FormModel = function(params){

        var self = this;

        this.inited = ko.observable(false);

        this.rubricsList = params.rubricsList;

        this.selectedRubric = params.selectedRubric;

        this.postTitle = ko.observable(params.title);

        this.postText = ko.observable(params.text);

        this.postIsNew = ko.observable(params.isNew);

        this.init = function(){

            this.inited(true)

        }

        this.init();
    };
JS;

$js .= "ko.applyBindings(new FormModel(" . CJSON::encode($json) . "), document.getElementById('add-article'));";

$cs->registerAMD('add-post', array('ko' => 'knockout', 'ko_library' => 'ko_library'), $js);

?>
