<?php
/**
 * @var $form CActiveForm
 * @var $model User
 * @var $odnoklassniki bool
 */

Yii::app()->clientScript->registerScript('auth-services-init', '$(".social-btn a").eauth({"popup":{"width":680,"height":500},"id":"odnoklassniki"});');
?>
<?php if($this->show_form): ?>
    <?php if ($this->form_type == 'horoscope'): ?>
        <script type="text/javascript">
            setTimeout(function(){Register.showStep2('', 'horoscope')}, 3000);
        </script>
    <?php else: ?>
        <script type="text/javascript">
            Register.show_window_delay = 3000;
            Register.show_window_type = "'.$this->form_type.'";
            if (document.referrer.substring(0, 22) != "http://www.rambler.ru/") Register.showRegisterWindow();
        </script>
    <?php endif; ?>
<?php endif; ?>
    <a id="hidden_register_link" href="#" class="fancy" style="display: none;"></a>
    <div style="display:none">
        <div id="register">
            <?php $this->render('step1',compact('model', 'type')); ?>
            <div class="other-steps"></div>
        </div>
    </div>
<?php
if ($this->form_type == 'odnoklassniki')
    $this->render('_odnoklassniki');
elseif ($this->form_type == 'pregnancy')
    $this->render('_pregnancy', compact('model'));
