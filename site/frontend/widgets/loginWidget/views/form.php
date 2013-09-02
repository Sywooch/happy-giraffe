<div style="display:none">
    <div id="login" class="popup-sign">
        <a class="popup-transparent-close powertip" onclick="$.fancybox.close();" href="javascript:void(0);" title="Закрыть"></a>
        <div class="clearfix">
            <div class="w-830">

                <div class="b-settings-blue">
                    <div class="b-sign">
                        <div class="b-sign_t">
                            <span class="ico-lock-big"></span>
                            Вход на сайт
                        </div>

                        <div class="clearfix">
                            <div class="b-sign_left-soc">
                                <div class="b-sign_sub-t margin-b30">Через социальные сети</div>
                                <div class="clearfix">
                                    <a class="b-social-big" href="">
                                        <span class="b-social-big_ico odnoklassniki"></span>
                                    </a>
                                    <a class="b-social-big" href="">
                                        <span class="b-social-big_ico vkontakte"></span>
                                    </a>
                                    <a class="b-social-big" href="">
                                        <span class="b-social-big_ico facebook"></span>
                                    </a>
                                    <a class="b-social-big" href="">
                                        <span class="b-social-big_ico twitter"></span>
                                    </a>
                                </div>
                            </div>

                            <div class="b-sign_right-b">
                                <?php $form = $this->beginWidget('CActiveForm', array(
                                    'id' => 'login-form',
                                    'action' => Yii::app()->createUrl('site/login'),
                                    'enableClientValidation' => false,
                                    'enableAjaxValidation' => true,
                                    'clientOptions' => array(
                                        'validateOnSubmit' => true,
                                        'validateOnChange' => false,
                                    )));
                                ?>
                                <div class="margin-b20 margin-t40 clearfix">
                                    <div class="b-sign_label-hold">
                                        <label for="" class="b-sign_label">E-mail</label>
                                    </div>
                                    <div class="b-sign_itx-hold">
                                        <?= $form->textField($model, 'email', array('class' => 'itx-simple')); ?>
                                        <?= $form->error($model, 'email'); ?>
                                    </div>
                                    <div class="b-sign_win"></div>
                                </div>
                                <div class="margin-b20 clearfix">
                                    <div class="b-sign_label-hold">
                                        <label for="" class="b-sign_label">Пароль</label>
                                    </div>
                                    <div class="b-sign_itx-hold">
                                        <?= $form->passwordField($model, 'password', array('class' => 'itx-simple')); ?>
                                        <?= $form->error($model, 'password'); ?>
                                    </div>
                                </div>
                                <div class="margin-b20 clearfix">
                                    <div class="b-sign_label-hold">
                                        <label for="" class="b-sign_label"></label>
                                    </div>
                                    <div class="b-sign_itx-hold">
                                        <?= HHtml::link('Забыли пароль?', $this->controller->createUrl('/site/passwordRecoveryForm'), array('class'=>'display-ib margin-t15 fancy', 'data-theme'=>'transparent'), true) ?>
                                        <button class="float-r btn-blue btn-h46">Войти</button>
                                    </div>
                                </div>
                                <?php $this->endWidget(); ?>
                            </div>
                        </div>
                        <div class="b-sign_bottom">
                            Вы еще не зарегистрированы?
                            <a href="#register" class="margin-l10 fancy" data-theme="transparent">Регистрация</a>
                        </div>
                    </div>



                </div>

            </div>
        </div>
    </div>
</div>