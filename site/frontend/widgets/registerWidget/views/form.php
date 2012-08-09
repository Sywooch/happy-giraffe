<?php
/**
 * @var $type string
 * @var $form CActiveForm
 * @var $model User
 * @var $odnoklassniki bool
 */

$script = <<<EOD
$(".social-btn a").eauth({"popup":{"width":680,"height":500},"id":"odnoklassniki"});
EOD;
Yii::app()->clientScript->registerScript('auth-services-init', $script);

if (Yii::app()->controller->registerUserData !== null) {
    Yii::app()->clientScript->registerScript('reg23', 'Register.showSocialStep2();');
    $regdata = Yii::app()->controller->registerUserData;
    $model = Yii::app()->controller->registerUserModel;
} elseif ($odnoklassniki) {
    Yii::app()->clientScript->registerScript('reg_change_reg_form', '
    $("#register .reg1").html($("#reg-odnoklassniki").html());
    $("a.auth-service2.odnoklassniki").eauth({"popup":{"width":680,"height":500},"id":"odnoklassniki"});
    Register.showRegisterWindow();
');
}
?>
<div style="display:none">
<div id="register" class="popup">
<a href="javascript:void(0);" class="popup-close tooltip" onclick="$.fancybox.close();"></a>

<div class="reg1">
    <div class="block-title" style="text-align:center;"><?=$this->template[$type]['step1']['title1'] ?></div>

    <div class="hl">
        <span><?=$this->template[$type]['step1']['title2'] ?></span>
    </div>

    <div class="clearfix">

        <div class="register-socials">

            <div class="box-title">Регистрация через<br/>социальные сети</div>

            <?php Yii::app()->eauth->renderWidget(array('action' => 'signup/index')); ?>

        </div>

        <div class="register-mail">

            <div class="box-title">Регистрация с помощью<br/>электронной почты</div>

            <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'reg-form1',
            'action' => '#',
            'enableClientValidation' => false,
            'enableAjaxValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
                'validateOnChange' => true,
                'validateOnType' => true,
                'validationUrl' => Yii::app()->createUrl('/signup/validate', array('step' => 1)),
                'afterValidate' => "js:function(form, data, hasError) {
                            if (!hasError){
                                Register.step1();
                            }
                            return false;
                          }",
            )));?>
            <?=$form->textField($model, 'email', array('class' => 'regmail1', 'placeholder' => 'Введите ваш e-mail')); ?>
            <?=$form->error($model, 'email'); ?>
            <input type="submit" value="OK"/>
            <?php $this->endWidget(); ?>

            <ul>
                <li>Мы не любим спам</li>
                <li>Мы не передадим ваши контакты третьим лицам</li>
                <li>Вы можете изменить настройки электронной почты в любое время</li>
            </ul>

        </div>

    </div>

    <div class="is-user">
        Вы уже зарегистрированы? <a href="#login" class="fancy" data-theme="white-square">Войти</a>
    </div>

</div>

<div class="reg2" style="display: none;">

    <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'reg-form2',
    'action' => '#',
    'enableClientValidation' => false,
    'enableAjaxValidation' => true,
    'clientOptions' => array(
        'inputContainer' => '.row',
        'validateOnSubmit' => true,
        'validateOnChange' => true,
        'validateOnType' => false,
        'validationUrl' => Yii::app()->createUrl('/signup/validate', array('step' => 2)),
        'afterValidate' => "js:function(form, data, hasError) {
                            if (!hasError){
                                Register.finish();
                            }
                            return false;
                          }",
    )));?>

    <div class="register-form">

        <div class="block-title"><?=$this->template[$type]['step2']['title1'] ?></div>

        <div class="hl">
            <span><?=$this->template[$type]['step2']['title2'] ?></span>
        </div>

        <div class="clearfix">

            <?php if (isset($regdata)):?>
                <div class="ava-box">

                    <div class="ava"<?php if (!isset($regdata['avatar'])) echo ' style="display:none;"' ?>>
                        <?=CHtml::image($regdata['photo'], 'Это Вы') ?>
                    </div>

                </div>
                <?=CHtml::hiddenField('form_type', $type) ?>
                <?php if (isset($regdata['avatar'])) echo $form->hiddenField($model, 'avatar', array('value' => $regdata['avatar'])); ?>
            <?php endif ?>

            <div class="form-in">

                <div class="row clearfix">
                    <div class="row-title">
                        <label>Имя:</label>
                    </div>
                    <div class="row-elements">
                        <?=$form->textField($model, 'first_name'); ?>
                    </div>
                    <div class="row-error">
                        <i class="error-ok"></i>
                        <?=$form->error($model, 'first_name'); ?>
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="row-title">
                        <label>Фамилия:</label>
                    </div>
                    <div class="row-elements">
                        <?=$form->textField($model, 'last_name'); ?>
                    </div>
                    <div class="row-error">
                        <i class="error-ok"></i>
                        <?=$form->error($model, 'last_name'); ?>
                    </div>
                </div>

                <div class="row clearfix email2-row" style="display: none;">
                    <div class="row-title">
                        <label>E-mail:</label>
                    </div>
                    <div class="row-elements">
                        <?=$form->textField($model, 'email', array('class' => 'regmail2', 'placeholder' => 'Введите ваш e-mail')); ?>
                    </div>
                    <div class="row-error">
                        <i class="error-ok"></i>
                        <?=$form->error($model, 'email'); ?>
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="row-title">
                        <label>Пароль:</label>
                    </div>
                    <div class="row-elements">
                        <?=$form->passwordField($model, 'password'); ?>
                    </div>
                    <div class="row-error">
                        <i class="error-ok"></i>
                        <?=$form->error($model, 'password'); ?>
                    </div>
                </div>

                <?php if ($this->template[$type]['inputBirthday']): ?>
                <div class="clearfix row-date">
                    <div class="row clearfix" style="display: inline-block;">
                        <div class="row-title">
                            <label>Пол:</label>
                        </div>
                        <div class="row-elements">
                            <?=$form->radioButtonList($model, 'gender', array(1 => 'Мужской', 0 => 'Женский'), array(
                            'template' => '{input}{label}',
                            'separator' => '',
                        )); ?>
                        </div>
                        <br>

                        <div class="row-error">
                            <i class="error-ok"></i>
                            <?=$form->error($model, 'gender'); ?>
                        </div>
                    </div>

                    <div class="row clearfix" style="display: inline-block;">
                        <div class="row-elements">
                            <span
                                class="chzn-v2"><?=$form->dropDownList($model, 'day', HDate::Range(1, 31), array('class' => 'chzn', 'empty' => 'День', 'style' => 'width:60px;')); ?></span>
                            <span
                                class="chzn-v2"><?=$form->dropDownList($model, 'month', HDate::ruMonths(), array('class' => 'chzn', 'empty' => 'Месяц', 'style' => 'width:80px;')); ?></span>
                            <span
                                class="chzn-v2"><?=$form->dropDownList($model, 'year', HDate::Range(date('Y') - 18, 1900), array('class' => 'chzn', 'empty' => 'Год', 'style' => 'width:60px;')); ?></span>
                            <?=$form->textField($model, 'birthday', array('style' => 'display:none;')); ?>
                        </div>
                        <br>

                        <div class="row-error">
                            <i class="error-ok"></i>
                            <?= $form->error($model, 'birthday'); ?>
                        </div>
                    </div>
                </div>
                <?php else: ?>
                <?php if (isset($regdata['birthday'])) echo $form->hiddenField($model, 'birthday', array('value' => $regdata['birthday'])); ?>

                <div class="row clearfix">
                    <div class="row-title">
                        <label>Пол:</label>
                    </div>
                    <div class="row-elements">
                        <?=$form->radioButtonList($model, 'gender', array(1 => 'Мужской', 0 => 'Женский'), array(
                        'template' => '{input}{label}',
                        'separator' => '',
                    )); ?>
                    </div>
                    <div class="row-error">
                        <i class="error-ok"></i>
                        <?=$form->error($model, 'gender'); ?>
                    </div>
                </div>
                <?php endif ?>

                <div class="row clearfix row-center">
                    <input type="submit" value="Регистрация">
                </div>

            </div>

        </div>

    </div>

    <?php $this->endWidget(); ?>
</div>

<div class="register-finish reg3 clearfix" style="display: none;">

    <div class="logo-box">
        <?=HHtml::link('', '/', array('class' => 'logo'), true)?>
    </div>

    <div class="green">Ура, вы с нами!</div>

    <div class="ava"<?php if (!isset($regdata['avatar'])) echo ' style="display:none;"' ?>></div>

    <div class="preparing"><?=$this->template[$type]['step3']['title1'] ?><span><span
        id="reg_timer">3</span> сек.</span></div>

</div>

</div>
</div>

<div id="reg-odnoklassniki" style="display: none;">
    <div class="register-social clearfix">

        <div class="block-title">Стань другом Веселого Жирафа!</div>

        <div class="hl">
            Быстрая регистрация с помощью Одноклассников. <span>Нажми на кнопку!</span>
        </div>

        <div class="social-btn">
            <?=HHtml::link('<img src="/images/btn_register_big_ok.png">', Yii::app()->createUrl('signup/index', array('service' => 'odnoklassniki')), array('class' => 'auth-service2 odnoklassniki'), true) ?>
        </div>

    </div>
    <div class="is-user">
        Вы уже зарегистрированы? <a href="#login" class="fancy" data-theme="white-square">Войти</a>
    </div>
</div>
