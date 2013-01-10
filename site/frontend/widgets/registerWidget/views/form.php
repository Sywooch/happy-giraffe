<?php
/**
 * @var $form CActiveForm
 * @var $model User
 * @var $odnoklassniki bool
 */

Yii::app()->clientScript->registerScript('auth-services-init', '$(".social-btn a").eauth({"popup":{"width":680,"height":500},"id":"odnoklassniki"});');

if($this->show_form){
    if ($this->form_type == 'horoscope'){
        Yii::app()->clientScript->registerScript('show_reg_form', "setTimeout(function(){Register.showStep2('', 'horoscope')}, 3000)");
    } else {
        Yii::app()->clientScript->registerScript('show_reg_form', '
            Register.show_window_delay = 3000;
            Register.show_window_type = "'.$this->form_type.'";
            Register.showRegisterWindow();');
    }
}?>
<a id="hidden_register_link" href="#" class="fancy" style="display: none;"></a>
<div style="display:none">
    <div id="register" class="popup">
        <a href="javascript:void(0);" class="popup-close tooltip" onclick="$.fancybox.close();"></a>

        <?php $this->render('step1',compact('model', 'type')); ?>

        <div class="other-steps"></div>

    </div>
</div>
<?php
if ($this->form_type == 'odnoklassniki')
    $this->render('_odnoklassniki');
elseif ($this->form_type == 'pregnancy')
    $this->render('_pregnancy', compact('model'));
