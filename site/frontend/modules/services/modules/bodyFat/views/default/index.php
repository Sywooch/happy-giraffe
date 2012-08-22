<?php
$basePath = Yii::getPathOfAlias('bodyFat') . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'default' . DIRECTORY_SEPARATOR . 'assets';
$baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
Yii::app()->clientScript->registerScriptFile($baseUrl . '/script.js', CClientScript::POS_HEAD);
?>


<div class="form">

    <?php

    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'body-fat-form',
        'action' => $this->createUrl('calculate'),
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'validateOnChange' => false,
            'validateOnType' => false,
            'validationUrl' => $this->createUrl('calculate'),
            'afterValidate' => "js:function(form, data, hasError) {
                                if (!hasError)
                                    bodyFat.Calculate();
                                return false;
                              }",
        )));
    ?>

    <?php
    //echo $form->errorSummary($model);

    ?>

    <div class="row">
        <?php echo $form->labelEx($model,'sex'); ?>
        <?php echo $form->dropDownList($model, 'sex', $model->sexes, array('class' => 'chzn')) ?>
        <?php echo $form->error($model,'sex'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'height'); ?>
        <?php echo $form->textField($model, 'height'); ?>
        <?php echo $form->error($model, 'height'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'weight'); ?>
        <?php echo $form->textField($model, 'weight'); ?>
        <?php echo $form->error($model, 'weight'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'waist'); ?>
        <?php echo $form->textField($model, 'waist'); ?>
        <?php echo $form->error($model, 'waist'); ?>
    </div>


    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->

<div id="result">

</div>