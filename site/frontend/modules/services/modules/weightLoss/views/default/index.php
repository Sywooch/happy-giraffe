<?php
$basePath = Yii::getPathOfAlias('weightLoss') . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'default' . DIRECTORY_SEPARATOR . 'assets';
$baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
Yii::app()->clientScript->registerScriptFile($baseUrl . '/script.js', CClientScript::POS_HEAD);
?>


<div class="form">

    <?php

    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'weight-loss-form',
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
                                    weightloss.Calculate();
                                return false;
                              }",
        )));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php
    //echo $form->errorSummary($model);
    ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'sex'); ?>
        <?php echo $form->dropDownList($model, 'sex', $dailyModel->sexes, array('class' => 'chzn')) ?>
        <?php echo $form->error($model, 'sex'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'age'); ?>
        <?php echo $form->textField($model, 'age'); ?>
        <?php echo $form->error($model, 'age'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'growth'); ?>
        <?php echo $form->textField($model, 'growth'); ?>
        <?php echo $form->error($model, 'growth'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'weight'); ?>
        <?php echo $form->textField($model, 'weight'); ?>
        <?php echo $form->error($model, 'weight'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'activity'); ?>
        <?php echo $form->dropDownList($model, 'activity', $dailyModel->activities, array('class' => 'chzn')) ?>
        <?php echo $form->error($model, 'activity'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'loss'); ?>
        <?php echo $form->textField($model, 'loss'); ?>
        <?php echo $form->error($model, 'loss'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'days'); ?>
        <?php echo $form->textField($model, 'days'); ?>
        <?php echo $form->error($model, 'days'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->

<div id="result">
</div>