<?php
/**
 * @var CActiveForm $form
 * @var ResendConfirmForm $model
 * @todo Выяснить почему пришлось выключить клиентскую валидацию
 */
?>

<div class="popup-sign_top">
    <div class="popup-sign_t">Добро пожаловать Александр! <br> Теперь вы с Веселым Жирафом!</div>
</div>
<div class="popup-sign_cont">
    <div class="popup-sign_col">
        <?php $form = $this->beginWidget('site\frontend\components\requirejsHelpers\ActiveForm', array(
            'id' => 'resendConfirmForm',
            'action' => array('/signup/register/resend'),
            'enableAjaxValidation' => true,
            'enableClientValidation' => false,
            'clientOptions' => array(
                'inputContainer' => 'div.inp-valid',
                'validateOnSubmit' => true,
                'afterValidate' => 'js:afterValidateResend',
            ),
        )); ?>
        <?=CHtml::hiddenField('ResendConfirmForm[id]', '', array(
            'data-bind' => 'value: id',
        ))?>
        <div class="popup-sign_row margin-t5">
            <div class="inp-valid inp-valid__abs success">
                <?=$form->textField($model, 'email', array(
                    'placeholder' => 'E-mail',
                    'class' => 'itx-gray popup-sign_itx',
                    'data-bind' => 'value: email.val, valueUpdate: \'input\'',
                ))?>
                <div class="inp-valid_error">
                    <?=$form->error($model, 'email')?>
                </div>
                <div class="inp-valid_success inp-valid_success__ico-check"></div>
            </div>
            <div class="popup-sign_tx-help">Пожалуйста проверьте правильность указанного адреса электронной почты или введите другой</div>
        </div>
        <div class="popup-sign_row">
            <div class="popup-sign_label">Код</div>
        </div>
        <div class="popup-sign_row margin-b30">
            <div class="popup-sign_capcha-hold">
                <?php $this->widget('RegisterCaptcha', array('captchaAction' => '/signup/register/captcha2', 'id' => 'ResendConfirmCaptcha')); ?>
            </div>
            <div class="popup-sign_capcha-inp">
                <div class="inp-valid inp-valid__abs">
                    <?=$form->textField($model, 'verifyCode', array(
                        'class' => 'itx-gray popup-sign_itx',
                    ))?>
                    <div class="inp-valid_error">
                        <?=$form->error($model, 'verifyCode')?>
                    </div>
                    <div class="inp-valid_success inp-valid_success__ico-check"></div>
                </div>
                <div class="popup-sign_tx-help">Введите код с картинки</div>
            </div>
        </div>
        <div class="popup-sign_row">
            <div class="display-ib textalign-c">
                <button class="btn-green-simple btn-l margin-b5">Отправить письмо еще раз</button>
                <div class="popup-sign_tx-help">Письмо должно прийти в течении 10 мин.</div>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
    <div class="popup-sign_col-wide-r">
        <div class="margin-b15">Письмо может попасть в папку "Спам" вашего почтового ящика. Если это так, пожалуйста, отметьте его как <strong class="color-gray-darken">"Не спам"</strong>.</div><?php $this->render('_mailServiceLink'); ?>
    </div>
</div>

<script type="text/javascript">
    function afterValidateResend(form, data, hasError) {
        if (! hasError) {
            $.post(form.attr('action'), form.serialize(), function(response) {
                if (response.success) {
                    form.triggerHandler('reset');
                    $('#ResendConfirmCaptcha_button').trigger('click');
                    $('#ResendConfirmForm_verifyCode').val('');
                    registerVm.currentStep(registerVm.STEP_EMAIL1);
                }
            }, 'json');
        }
        return false;
    }
</script>