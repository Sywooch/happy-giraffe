<?php
/**
 * @var $form CActiveForm
 * @var $model User
 * @var $odnoklassniki bool
 */

Yii::app()->clientScript->registerScript('auth-services-init', '$(".social-btn a").eauth({"popup":{"width":680,"height":500},"id":"odnoklassniki"});');

if (Yii::app()->controller->registerUserData !== null) {
    Yii::app()->clientScript->registerScript('reg23', 'Register.showSocialStep2();');
    $regdata = Yii::app()->controller->registerUserData;
    $model = Yii::app()->controller->registerUserModel;
} elseif($this->show_form){
    Yii::app()->clientScript->registerScript('show_reg_form', '
    Register.show_window_delay = 3000;
    Register.show_window_type = "'.$this->form_type.'";
    Register.showRegisterWindow();');
}?>
<a id="hidden_register_link" href="#" class="fancy" style="display: none;"></a>
<div style="display:none">
    <div id="register" class="popup">
        <a href="javascript:void(0);" class="popup-close tooltip" onclick="$.fancybox.close();"></a>

        <?php $this->render('step1',compact('model', 'regdata', 'type')); ?>

        <div class="other-steps"></div>

    </div>
</div>
<?php
if ($this->form_type == 'odnoklassniki')
    $this->render('_odnoklassniki');
elseif ($this->form_type == 'pregnancy')
    $this->render('_pregnancy', compact('model'));
