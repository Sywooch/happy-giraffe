<?php
/**
 * @var RegisterWidget $this
 * @var User $model
 */
?>

<div class="popup-container display-n">
    <div id="registerWidget" class="popup popup-sign">
        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'registerForm',
            'enableAjaxValidation' => true,
            'enableClientValidation' => true,
            'clientOptions' => array(
                'inputContainer' => 'div.inp-valid',
                'validationUrl' => Yii::app()->createUrl('/signup/default/validation'),
                'validateOnSubmit' => true,
            ),
        )); ?>
        <?=CHtml::hiddenField('step', '', array(
            'data-bind' => 'value: currentStep',
        ))?>
        <div class="popup-sign_hold">
            <!-- ko if: currentStep() == STEP_REG1 -->
            <?php $this->render('reg1', compact('form', 'model')); ?>
            <!-- /ko -->
            <!-- ko if: currentStep() == STEP_REG2 -->
            <?php $this->render('reg2'); ?>
            <!-- /ko -->
            <!-- ko if: currentStep() == STEP_EMAIL1 -->
            <?php $this->render('email1'); ?>
            <!-- /ko -->
            <!-- ko if: currentStep() == STEP_EMAIL2 -->
            <?php $this->render('email2'); ?>
            <!-- /ko -->
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>

<script type="text/javascript">
    ko.applyBindings(new RegisterWidgetViewModel(), document.getElementById('registerWidget'));
</script>