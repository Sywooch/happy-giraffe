<?php
/**
 * @var $form CActiveForm
 * @var $show_form bool
 * @var $model User
 * @var $odnoklassniki bool
 */

$script = <<<EOD
$(".social-btn a").eauth({"popup":{"width":680,"height":500},"id":"odnoklassniki"});
EOD;
Yii::app()->clientScript->registerScript('auth-services-init',$script);

if (Yii::app()->controller->registerUserData !== null){
    Yii::app()->clientScript->registerScript('reg23','Register.showSocialStep2();');
    $regdata = Yii::app()->controller->registerUserData;
    $model = Yii::app()->controller->registerUserModel;
}elseif($odnoklassniki && $show_form){
    Yii::app()->clientScript->registerScript('reg_change_reg_form','
    $("#register .reg1").html($("#reg-odnoklassniki").html());
    $("a.auth-service2.odnoklassniki").eauth({"popup":{"width":680,"height":500},"id":"odnoklassniki"});
    Register.showRegisterWindow();
');
}

/*if ($show_form){
    Yii::app()->clientScript->registerScript('reg_show_window','Register.showRegisterWindow();');
    if (Yii::app()->controller->uniqueId == 'services/babySex/default' ){
        Yii::app()->clientScript->registerScript('reg_change_reg_form','$("#register .reg1").html($("#reg-odnoklassniki").html());');
    }
}*/
?>
<div style="display:none">
    <div id="register" class="popup">
    <a href="javascript:void(0);" class="popup-close tooltip" onclick="$.fancybox.close();"></a>
        <div class="reg1">

            <div class="block-title"><img src="/images/bg_register_title.png" />Регистрация на Веселом Жирафе</div>

            <div class="hl">
                <span>Стань полноправным участником сайта за 1 минуту!</span>
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
                        <?php echo $form->textField($model, 'email', array('class'=>'regmail1', 'placeholder'=>'Введите ваш e-mail')); ?>
                        <?php echo $form->error($model, 'email'); ?>
                        <input type="submit" value="OK" />
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
            'enableClientValidation' => true,
            'enableAjaxValidation' => true,
            'clientOptions' => array(
                'inputContainer'=>'.row',
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

                <div class="block-title">Вы уже почти с нами!</div>

                <div class="hl">
                    <span>Осталось ввести ваши имя, фамилию и пароль</span>
                </div>

                <div class="clearfix">

                    <div class="ava-box">

                        <div class="ava"<?php if (!isset($regdata['avatar'])) echo ' style="display:none;"' ?>></div>

                    </div>

                    <?php if (isset($regdata['birthday'])) echo $form->hiddenField($model, 'birthday', array('value' => $regdata['birthday'])); ?>
                    <?php if (isset($regdata['avatar'])) echo $form->hiddenField($model, 'avatar', array('value' => $regdata['avatar'])); ?>

                    <div class="form-in">

                        <div class="row clearfix">
                            <div class="row-title">
                                <label>Имя:</label>
                            </div>
                            <div class="row-elements">
                                <?php echo $form->textField($model, 'first_name'); ?>
                            </div>
                            <div class="row-error">
                                <i class="error-ok"></i>
                                <?php echo $form->error($model, 'first_name'); ?>
                            </div>
                        </div>

                        <div class="row clearfix">
                            <div class="row-title">
                                <label>Фамилия:</label>
                            </div>
                            <div class="row-elements">
                                <?php echo $form->textField($model, 'last_name'); ?>
                            </div>
                            <div class="row-error">
                                <i class="error-ok"></i>
                                <?php echo $form->error($model, 'last_name'); ?>
                            </div>
                        </div>

                        <div class="row clearfix email2-row" style="display: none;">
                            <div class="row-title">
                                <label>E-mail:</label>
                            </div>
                            <div class="row-elements">
                                <?php echo $form->textField($model, 'email', array('class'=>'regmail2', 'placeholder'=>'Введите ваш e-mail')); ?>
                            </div>
                            <div class="row-error">
                                <i class="error-ok"></i>
                                <?php echo $form->error($model, 'email'); ?>
                            </div>
                        </div>

                        <div class="row clearfix">
                            <div class="row-title">
                                <label>Пароль:</label>
                            </div>
                            <div class="row-elements">
                                <?php echo $form->passwordField($model, 'password'); ?>
                            </div>
                            <div class="row-error">
                                <i class="error-ok"></i>
                                <?php echo $form->error($model, 'password'); ?>
                            </div>
                        </div>

                        <div class="row clearfix">
                            <div class="row-title">
                                <label>Пол:</label>
                            </div>
                            <div class="row-elements">
                                <?php echo $form->radioButtonList($model, 'gender', array(1 => 'Мужской', 0 => 'Женский'), array(
                                'template'=>'{input}{label}',
                                'separator'=>'',
                            )); ?>
                            </div>
                            <div class="row-error">
                                <i class="error-ok"></i>
                                <?php echo $form->error($model, 'gender'); ?>
                            </div>
                        </div>

                        <div class="row clearfix">
                            <input type="submit" value="Регистрация">
                        </div>

                    </div>

                </div>

            </div>

            <?php $this->endWidget(); ?>
        </div>

        <div class="register-finish reg3 clearfix" style="display: none;">

            <div class="logo-box">
                <?=HHtml::link('', '/', array('class'=>'logo'), true)?>
            </div>

            <div class="green">Ура, вы с нами!</div>

            <div class="ava"<?php if (!isset($regdata['avatar'])) echo ' style="display:none;"' ?>></div>

            <div class="preparing">Мы готовим для вас личную страницу <span><span id="reg_timer">3</span> сек.</span></div>

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
            <?=HHtml::link('<img src="/images/btn_register_big_ok.png">',Yii::app()->createUrl('signup/index', array('service'=>'odnoklassniki')), array('class'=>'auth-service2 odnoklassniki'), true) ?>
        </div>

    </div>
    <div class="is-user">
        Вы уже зарегистрированы? <a href="#login" class="fancy" data-theme="white-square">Войти</a>
    </div>
</div>
