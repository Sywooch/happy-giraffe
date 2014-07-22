<?php
/**
 * @var LoginForm $model
 */
?>

<div class="popup-container display-n">
    <div id="loginWidget" class="popup popup-sign">
        <?php $form = $this->beginWidget('site\frontend\components\requirejsHelpers\ActiveForm', array(
            'id' => 'loginForm',
            'action' => array('/signup/login/default'),
            'enableAjaxValidation' => true,
            'enableClientValidation' => true,
            'clientOptions' => array(
                'inputContainer' => 'div.inp-valid',
                'validateOnSubmit' => true,
            ),
        ))?>
        <div class="popup-sign_hold">
            <div class="popup-sign_top">
                <div class="popup-sign_t"><span class="ico-lock-big"></span>Вход на сайт</div>
            </div>
            <div class="popup-sign_cont">
                <div class="popup-sign_social">
                    <div class="popup-sign_row">
                        <div class="popup-sign_label">Быстрый вход</div>
                    </div>
                    <?php $this->widget('AuthWidget', array('action' => '/signup/login/social', 'view' => 'inside')); ?>
                </div>
                <div class="popup-sign_col">
                    <div class="popup-sign_row">
                        <div class="popup-sign_label"><?=$model->getAttributeLabel('email')?></div>
                    </div>
                    <div class="popup-sign_row">
                        <div class="inp-valid inp-valid__abs inp-valid__error">
                            <?=$form->textField($model, 'email', array(
                                'placeholder' => 'E-mail',
                                'class' => 'itx-gray popup-sign_itx',
                                'data-bind' => 'value: email',
                            ))?>
                            <div class="inp-valid_error">
                                <div class="inp-valid_error-tx"><?=$form->error($model, 'email'); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="popup-sign_row">
                        <div class="popup-sign_label"><?=$model->getAttributeLabel('Пароль')?></div>
                    </div>
                    <div class="popup-sign_row">
                        <div class="inp-valid inp-valid__abs inp-valid__success">
                            <?=$form->passwordField($model, 'password', array(
                                'placeholder' => 'Пароль',
                                'class' => 'itx-gray popup-sign_itx',
                                'data-bind' => 'value: password',
                            ))?>
                            <div class="inp-valid_error">
                                <div class="inp-valid_error-tx"><?=$form->error($model, 'password'); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="popup-sign_row">
                        <div class="float-r">
                            <div class="display-ib textalign-c">
                                <button class="btn-green-simple btn-l margin-b10">Войти на сайт</button><br><a class="popup-a" href="#passwordRecoveryWidget" data-bind="click: recover">Забыли пароль?</a>
                            </div>
                        </div>
                        <div class="float-l">
                            <div class="checkbox-icons">
                                <?=$form->checkBox($model, 'rememberMe', array('class' => 'checkbox-icons_radio', 'data-bind' => 'checked: rememberMe'))?>
                                <?=$form->label($model, 'rememberMe', array('class' => 'checkbox-icons_label'))?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="popup-sign_b"><span class="popup-sign_b-tx">Вы еще не зарегистрированы?</span><a class="popup-sign_b-a popup-a" href="#registerWidget">Регистрация</a></div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>

<script type="text/javascript">
    <?php
    $js = "ko.applyBindings(new LoginWidgetViewModel(), document.getElementById('loginWidget'));";
    $cs = Yii::app()->clientScript;
    if($cs->useAMD)
        $cs->registerAMD('LoginWidgetViewModel', array('ko' => 'knockout', 'ko_registerWidget' => 'ko_registerWidget'), $js);
    else
        $cs->registerScript('LoginWidgetViewModel', $js, ClientScript::POS_READY);
    ?>
</script>