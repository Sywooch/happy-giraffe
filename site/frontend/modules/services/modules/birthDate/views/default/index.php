<?php
$basePath = Yii::getPathOfAlias('birthDate') . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'default' . DIRECTORY_SEPARATOR . 'assets';
$baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
Yii::app()->clientScript->registerScriptFile($baseUrl . '/script.js', CClientScript::POS_HEAD);
?>



<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm',
        array(
            'id' => 'birth-date-form',
            'action' => $this->createUrl('/birthDate/calculate'),
            'enableAjaxValidation' => true,
            'enableClientValidation' => false,
            'clientOptions' => array(
                'validateOnSubmit' => true,
                'validateOnChange' => false,
                'validateOnType' => false,
                'validationUrl' => $this->createUrl('/birthDate/calculate'),
                'afterValidate' => "js:function(form, data, hasError) {
                                if (!hasError)
                                    birthDate.Calculate();
                                return false;
                              }",
            )
        )
    );
    ?>



    <div class="row">
        <?php echo $form->labelEx($model, 'day'); ?>
        <?php echo $form->dropDownList($model, 'day', HDate::Days(), array('class' => 'chzn', 'empty' => '-')); ?>
        <?php echo $form->error($model, 'day'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'month'); ?>
        <?php echo $form->dropDownList($model, 'month', HDate::ruMonths(), array('class' => 'chzn', 'empty' => '-')); ?>
        <?php echo $form->error($model, 'month'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'year'); ?>
        <?php echo $form->dropDownList($model, 'year', HDate::Range(date('Y') - 5, date('Y')), array('class' => 'chzn', 'empty' => '-')); ?>
        <?php echo $form->error($model, 'year'); ?>
    </div>


    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->

<div id="result">
</div>