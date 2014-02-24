<?php
/**
 * @var RegisterWidget $this
 * @var User $model
 * @var mixed $json
 */
?>

<div class="popup-container display-n">
    <div id="registerWidget" class="popup popup-sign">
        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'registerForm',
            'action' => array('/signup/default/reg'),
            'enableAjaxValidation' => true,
            'enableClientValidation' => true,
            'clientOptions' => array(
                'inputContainer' => 'div.inp-valid',
                'validateOnSubmit' => true,
                'afterValidate' => 'js:afterValidate',
            ),
        )); ?>
        <?=CHtml::hiddenField('step', '', array(
            'data-bind' => 'value: currentStep',
        ))?>
        <?=CHtml::hiddenField('social', '', array(
            'data-bind' => 'value: social',
        ))?>
        <?=CHtml::hiddenField('User[id]', '', array(
            'data-bind' => 'value: id',
        ))?>

        <div class="popup-sign_hold" data-bind="visible: currentStep() == $root.STEP_REG1">
            <?php $this->render('reg1', compact('form', 'model')); ?>
        </div>
        <div class="popup-sign_hold" data-bind="visible: currentStep() == $root.STEP_REG2">
            <?php $this->render('reg2', compact('form', 'model')); ?>
        </div>
        <div class="popup-sign_hold" data-bind="visible: currentStep() == $root.STEP_EMAIL1">
            <?php $this->render('email1', compact('form', 'model')); ?>
        </div>
        <div class="popup-sign_hold" data-bind="visible: currentStep() == $root.STEP_EMAIL2">
            <?php $this->render('email2', compact('form', 'model')); ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>

<script type="text/javascript">
    registerVm = new RegisterWidgetViewModel(<?=CJSON::encode($json)?>, $('#registerForm'));
    ko.applyBindings(registerVm, document.getElementById('registerWidget'));
    function afterValidate(form, data, hasError) {
        console.log(hasError);
        if (! hasError) {
            switch (registerVm.currentStep()) {
                case registerVm.STEP_REG1:
                    $.post(form.attr('action'), form.serialize(), function(response) {
                        if (response.success) {
                            registerVm.id(response.id);
                            $('#registerForm').triggerHandler('reset');
                            registerVm.currentStep(registerVm.STEP_REG2);
                        }
                    }, 'json');
                    break;
                case registerVm.STEP_REG2:
                    $.post(form.attr('action'), form.serialize(), function(response) {
                        if (response.success)
                            registerVm.currentStep(registerVm.STEP_EMAIL1);
                    }, 'json');
                    break;
            }
        }
        return false;
    }
</script>