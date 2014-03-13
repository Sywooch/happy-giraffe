<?php
/**
 * @var RegisterWidget $this
 * @var RegisterFormStep1 $modelStep1
 * @var RegisterFormStep2 $modelStep2
 * @var ResendConfirmForm $resendConfirm
 * @var AvatarUploadForm $avatarUpload
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
            <?php $this->render('email2', array('model' => $resendConfirm)); ?>
        </div>
        <div class="popup-sign_hold" data-bind="visible: currentStep() == STEP_PHOTO">
            <?php $this->render('photo', array('model' => $avatarUpload)); ?>
        </div>
        <div class="popup-sign_b clearfix margin-t20" data-bind="visible: currentStep() == STEP_PHOTO">
            <div class="float-r">
                <div class="btn-green-simple btn-l" data-bind="click: saveAvatar">Сохранить</div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function() {
        registerVm = new RegisterWidgetViewModel(<?=CJSON::encode($json)?>, $('#registerForm'));
        ko.applyBindings(registerVm, document.getElementById('registerWidget'));
    });


    $(function() {
        if (<?php Yii::app()->controller->renderDynamic(array($this, 'autoOpen')); ?>)
            setTimeout(function() {
                registerVm.open();
            }, 3000);
    });

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
            var data = form.serialize();
            if (registerVm.avatar.imgSrc() !== null) {
                data += '&' + $.param({
                    RegisterFormStep2 : {
                        avatar : {
                            imgSrc : registerVm.avatar.imgSrc(),
                            coords : registerVm.avatar.coords
                        }
                    }
                });
            }
            $.post(form.attr('action'), data, function(response) {
                if (response.success) {
                    registerVm.id(response.id);
                    registerVm.currentStep(registerVm.STEP_EMAIL1);
                }
            }, 'json');
        }
        return false;
    }

    function afterValidateResend(form, data, hasError) {
        if (! hasError) {
            $.post(form.attr('action'), form.serialize(), function(response) {
                if (response.success)
                    registerVm.currentStep(registerVm.STEP_EMAIL1);
            }, 'json');
        }
        return false;
    }
</script>