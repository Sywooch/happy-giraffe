<?php
/**
 * @var RegisterWidget $this
 * @var RegisterFormStep1 $modelStep1
 * @var RegisterFormStep2 $modelStep2
 * @var mixed $json
 */
?>

<div class="popup-container display-n">
    <div id="registerWidget" class="popup popup-sign">
        <div class="popup-sign_hold" data-bind="visible: currentStep() == STEP_REG1">
            <?php $this->render('reg1', array('model' => $modelStep1)); ?>
        </div>
        <div class="popup-sign_hold" data-bind="visible: currentStep() == STEP_REG2">
            <?php $this->render('reg2', array('model' => $modelStep2)); ?>
        </div>
        <div class="popup-sign_hold" data-bind="visible: currentStep() == STEP_EMAIL1">
            <?php $this->render('email1'); ?>
        </div>
        <div class="popup-sign_hold" data-bind="visible: currentStep() == STEP_EMAIL2">
            <?php $this->render('email2'); ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    registerVm = new RegisterWidgetViewModel(<?=CJSON::encode($json)?>, $('#registerForm'));
    ko.applyBindings(registerVm, document.getElementById('registerWidget'));

    function afterValidateStep1(form, data, hasError) {
        if (! hasError) {
            $.post(form.attr('action'), form.serialize(), function(response) {
                if (response.success) {
                    registerVm.id(response.id);
                    registerVm.currentStep(registerVm.STEP_REG2);
                }
            }, 'json');
        }
        return false;
    }

    function afterValidateStep2(form, data, hasError) {
        if (! hasError) {
            $.post(form.attr('action'), form.serialize(), function(response) {
                if (response.success)
                    registerVm.currentStep(registerVm.STEP_EMAIL1);
            }, 'json');
        }
        return false;
    }
</script>