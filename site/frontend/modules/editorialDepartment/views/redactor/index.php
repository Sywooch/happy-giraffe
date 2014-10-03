<?php

/**
 * @var site\frontend\modules\editorialDepartment\models\Content $model
 * @var CActiveForm $form
 */
$form = $this->beginWidget('site\frontend\components\requirejsHelpers\ActiveForm', array(
    'id' => 'blog-form',
    //'action' => $action,
    'enableAjaxValidation' => false,
    'enableClientValidation' => false,
    'clientOptions' => array(
        'validateOnSubmit' => false,
        'validateOnType' => false,
    )));

$form->hiddenField($model, 'clubId');
?>

    <?=$form->hiddenField($model, 'markDownPreview',  array('id' => 'markDownPreview'));?>
    <?=$form->hiddenField($model, 'htmlTextPreview',  array('id' => 'htmlTextPreview'));?>
    <?=$form->hiddenField($model, 'markDown',  array('id' => 'markDown'));?>
    <?=$form->hiddenField($model, 'htmlText',  array('id' => 'htmlText'));?>

    <div class="b-settings-blue_row clearfix">
        <div class="clearfix">
        </div>
        <label class="b-settings-blue_label" for="BlogContent_title">Заголовок</label>
        <div class="w-400 float-l">
            <?=$form->textField($model, 'title', array('class' => 'itx-simple w-400')) ?>
        </div>
    </div>


    <div class="b-settings-blue_row clearfix">
        <div class="clearfix">
        </div>
        <label class="b-settings-blue_label" for="BlogContent_title">Превью</label>
    </div>


    <md-redactor style="display: block; border: 1px solid #e0e1e2; border-radius: 3px;" params="id: 'md-redactor-1', textareaId: 'markDownPreview', htmlId: 'htmlTextPreview'"></md-redactor>

    <div class="b-settings-blue_row clearfix">
        <div class="clearfix">
        </div>
        <label class="b-settings-blue_label" for="BlogContent_title">Текст</label>
    </div>

    <md-redactor style="display: block; border: 1px solid #e0e1e2; border-radius: 3px;" params="id: 'md-redactor-2', textareaId: 'markDown', htmlId: 'htmlText'"></md-redactor>

    <div class="b-settings-blue_row clearfix">
        <div class="clearfix">
        </div>
        <label class="b-settings-blue_label" for="BlogContent_title">meta.title</label>
        <div class="w-400 float-l">
            <?=$form->textArea($model, 'meta[title]',  array('class' => 'itx-simple w-400')) ?>
        </div>
    </div>

    <div class="b-settings-blue_row clearfix">
        <div class="clearfix">
        </div>
        <label class="b-settings-blue_label" for="BlogContent_title">meta.keywords</label>
        <div class="w-400 float-l">
            <?=$form->textArea($model, 'meta[keywords]',  array('class' => 'itx-simple w-400')) ?>
        </div>
    </div>

    <div class="b-settings-blue_row clearfix">
        <div class="clearfix">
        </div>
        <label class="b-settings-blue_label" for="BlogContent_title">meta.description</label>
        <div class="w-400 float-l">
            <?=$form->textArea($model, 'meta[description]',  array('class' => 'itx-simple w-400')) ?>
        </div>
    </div>

    <div class="b-settings-blue_row clearfix">
        <div class="clearfix">
        </div>
        <label class="b-settings-blue_label" for="BlogContent_title">social.title</label>
        <div class="w-400 float-l">
            <?=$form->textArea($model, 'social[title]',  array('class' => 'itx-simple w-400')) ?>
        </div>
    </div>

    <div class="b-settings-blue_row clearfix">
        <div class="clearfix">
        </div>
        <label class="b-settings-blue_label" for="BlogContent_title">social.title</label>
        <div class="w-400 float-l">
            <?=$form->textArea($model, 'social[text]',  array('class' => 'itx-simple w-400')) ?>
        </div>
    </div>

    social.image <?=$form->hiddenField($model, 'social[image]') ?>

<?=CHtml::submitButton('save') ?>

<?php
$this->endWidget();

/**
 * @var ClientScript $cs
 */
$cs = Yii::app()->clientScript;
$cs->registerAMD("md-redactor", array("kow"));
?>