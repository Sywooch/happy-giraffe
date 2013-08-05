<div id="register-step1" class="popup-sign">
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
                        Register.redirectUrl = $('#register-redirectUrl').val();
                        Register.showStep2($('#reg-form1 #User_email').val(), 'default');
                    }
                    return false;
                  }",
    )));?>

    <a class="popup-transparent-close powertip" onclick="$.fancybox.close();" href="javascript:void(0);" title="Закрыть"></a>
    <div class="clearfix">
        <div class="w-830">

            <div class="b-settings-blue">
                <div class="b-sign">
                    <div class="b-sign_t">Регистрация на Веселом Жирафе</div>
                    <div class="textalign-c margin-b30">
                        <span class="i-highlight i-highlight__big font-big">Стань полноправным участником сайта за 1 минуту!</span>
                    </div>
                    <div class="clearfix">
                        <div class="b-sign_left-soc">
                            <div class="b-sign_sub-t margin-b30">Через социальные сети</div>
                            <div class="clearfix">
                                <a class="b-social-big" href="">
                                    <span class="b-social-big_ico odkl"></span>
                                </a>
                                <a class="b-social-big" href="">
                                    <span class="b-social-big_ico vk"></span>
                                </a>
                                <a class="b-social-big" href="">
                                    <span class="b-social-big_ico fb"></span>
                                </a>
                                <a class="b-social-big" href="">
                                    <span class="b-social-big_ico tw"></span>
                                </a>
                            </div>
                        </div>

                        <div class="b-sign_right-b">
                            <div class="b-sign_sub-t">С помощью электронной почты</div>
                            <div class="margin-b30 clearfix">
                                <div class="b-sign_itx-hold">
                                    <?=$form->textField($model, 'email', array('class' => 'itx-simple', 'placeholder' => 'Введите ваш e-mail')); ?>
                                    <?=$form->error($model, 'email'); ?>
                                </div>
                                <button class="btn-green btn-middle">Ok</button>
                            </div>
                            <ul class="b-sign_ul">
                                <li class="b-sign_li">Мы не любим спам</li>
                                <li class="b-sign_li">Мы не передадим ваши контакты третьим лицам</li>
                                <li class="b-sign_li">Вы можете изменить настройки электронной почты в любое время</li>
                            </ul>
                        </div>
                    </div>
                    <div class="b-sign_bottom">
                        Вы уже зарегистрированы?
                        <a href="" class="margin-l10">Войти</a>
                    </div>
                </div>



            </div>

        </div>
    </div>

    <?php $this->endWidget(); ?>
</div>

</div>