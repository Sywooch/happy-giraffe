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

Заголовок статьи <?=$form->textField($model, 'title') ?><br />
Превью (md) <?=$form->textArea($model, 'markDownPreview') ?><br />
Превью (html) <?=$form->textArea($model, 'htmlTextPreview') ?><br />
Текст (md) <?=$form->textArea($model, 'markDown') ?><br />
Текст (html) <?=$form->textArea($model, 'htmlText') ?><br />
meta.title <?=$form->textField($model, 'meta[title]') ?><br />
meta.keywords <?=$form->textArea($model, 'meta[keywords]') ?><br />
meta.description <?=$form->textArea($model, 'meta[description]') ?><br />
social.title <?=$form->textField($model, 'social[title]') ?><br />
social.text <?=$form->textArea($model, 'social[text]') ?><br />
social.image <?=$form->hiddenField($model, 'social[image]') ?><br />
<?=CHtml::submitButton('save') ?>

<?php
$this->endWidget();

/**
 * @var ClientScript $cs
 */
$cs = Yii::app()->clientScript;
?>