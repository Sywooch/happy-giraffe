<?php
/**
 * @var PasswordRecoveryForm $model
 */
?>

<div class="popup-container display-n">
    <div id="passwordRecoveryWidget" class="popup popup-sign">
        <?php $form = $this->beginWidget('site\frontend\components\requirejsHelpers\ActiveForm', array(
            'id' => 'passwordRecoveryForm',
            'action' => array('/signup/passwordRecovery/send'),
            'enableAjaxValidation' => true,
            'enableClientValidation' => true,
            'clientOptions' => array(
                'inputContainer' => 'div.inp-valid',
                'validateOnSubmit' => true,
                'afterValidate' => 'js:afterValidate',
            ),
        ))?>
        <div class="popup-sign_hold">
            <div class="popup-sign_top">
                <div class="popup-sign_t"><span class="ico-lock-big"></span>Вход на сайт</div>
            </div>
            <div class="popup-sign_cont">
                <div class="popup-sign_tx margin-t20">Пожалуйста введите ваш e-mail адрес. <br><span class="i-highlight">Вам будет выслано письмо с вашим паролем.</span></div>
                <div class="popup-sign_wrap">
                    <div class="popup-sign_row clearfix">
                        <div class="popup-sign_col-label">
                            <div class="popup-sign_label"><?=$model->getAttributeLabel('email')?></div>
                        </div>
                        <div class="popup-sign_col-inp">
                            <div class="inp-valid inp-valid__abs inp-valid__success">
                                <?=$form->textField($model, 'email', array(
                                    'class' => 'itx-gray popup-sign_itx',
                                    'data-bind' => 'value: email',
                                ))?>
                                <div class="inp-valid_error">
                                    <div class="inp-valid_error-tx"><?=$form->error($model, 'email')?></div>
                                </div>
                                <div class="inp-valid_success inp-valid_success__ico-check"></div>
                            </div>
                        </div>
                    </div>
                    <div class="textalign-r" data-bind="visible: ! isSent()">
                        <button class="btn-green-simple btn-l margin-b10">Отправить пароль</button>
                    </div>
                    <div data-bind="visible: isSent">
                        <div class="popup-sign_retrieve-send"><span class="i-highlight">На ваш e-mail адрес было выслано письмо с вашим паролем.</span><br><span class="i-highlight">Также проверьте, пожалуйста, папку «Спам».</span></div>
                        <div class="textalign-r">
                            <a class="btn-green-simple btn-l margin-b10 popup-a" href="#loginWidget" data-bind="click: login">Войти на сайт</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>

<script type="text/javascript">
    function afterValidate(form, data, hasError) {
        if (! hasError) {
            $.post(form.attr('action'), form.serialize(), function(response) {
                if (response.success)
                    passwordRecoveryVm.isSent(true);
            }, 'json');
        }
        return false;
    }
    
    <?php
    $js = "ko.applyBindings(new PasswordRecoveryWidgetViewModel(), document.getElementById('passwordRecoveryWidget'));";
    $cs = Yii::app()->clientScript;
    if ($cs->useAMD)
        $cs->registerAMD('PasswordRecoveryWidgetViewModel', array('ko' => 'knockout', 'ko_registerWidget' => 'ko_registerWidget'), $js);
    else
        $cs->registerScript('PasswordRecoveryWidgetViewModel', $js, ClientScript::POS_READY);
    ?>
</script>