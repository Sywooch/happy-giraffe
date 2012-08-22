<?php
$basePath = Yii::getPathOfAlias('idealWeight') . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'default' . DIRECTORY_SEPARATOR . 'assets';
$baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
Yii::app()->clientScript->registerScriptFile($baseUrl . '/script.js', CClientScript::POS_HEAD);
?>


<div class="form">

    <?php

    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'ideal-weight-form',
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
                                    idealweight.Calculate();
                                return false;
                              }",
        )));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php
    //echo $form->errorSummary($model);

    ?>

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


    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->

<div id="result">

</div>