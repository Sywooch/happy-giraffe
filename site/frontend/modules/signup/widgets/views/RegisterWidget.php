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
                <div class="btn-gray-simple btn-l btn btn-secondary" data-bind="click: cancelAvatar">Отменить</div> <button class="btn-green-simple btn-l margin-l5 btn btn-success" data-bind="click: saveAvatar, disable: ! avatar.isChanged()">Сохранить</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    <?php
    $cs = Yii::app()->clientScript;
    if($cs->useAMD)
        echo '$(document).ready(function() { require(["knockout", "ko_registerWidget"], function(ko) {';
    ?>
    registerVm = new RegisterWidgetViewModel(<?=CJSON::encode($json)?>, $('#registerForm'));
    ko.applyBindings(registerVm, document.getElementById('registerWidget'));
    if (<?php Yii::app()->controller->renderDynamic(array($this, 'autoOpen')); ?>)
            setTimeout(function() {
                registerVm.open();
            }, 3000);
    <?php
    if($cs->useAMD)
        echo '})});';
    ?>
</script>