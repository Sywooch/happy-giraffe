<div style="display:none">
    <div id="login" class="popup">

        <a href="javascript:void(0);" class="popup-close tooltip" onclick="$.fancybox.close()"></a>

        <div class="block-title"><img src="/images/bg_register_title.png">Вход на сайт</div>

        <div class="clearfix">

            <div class="login-form">

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
                    <input type="hidden" name="redirect_to" value="">
                    <div class="row clearfix">
                        <div class="row-title"><label>E-mail:</label></div>
                        <div class="row-elements"><?= $form->textField($model, 'email'); ?></div>
                        <p><?= $form->error($model, 'email'); ?></p>
                    </div>
                    <div class="row clearfix">
                        <div class="row-title"><label>Пароль:</label></div>
                        <div class="row-elements"><?= $form->passwordField($model, 'password'); ?></div>
                        <p><?= $form->error($model, 'password'); ?></p>
                    </div>
                    <div class="row clearfix">
                        <div class="row-title">&nbsp;</div>
                        <div class="row-elements"><input type="submit" value="Войти"> <?= HHtml::link('Забыли пароль?', $this->controller->createUrl('/site/passwordRecoveryForm'), array('class'=>'fancy', 'data-theme'=>'white-square'), true) ?></div>
                    </div>
                <?php $this->endWidget(); ?>

            </div>

            <div class="login-social">

                <div class="box-title hl"><span>Быстрый вход</span></div>

                <?php Yii::app()->eauth->renderWidget(array('action' => '/site/login')); ?>

            </div>

        </div>

        <div class="is-user hl">
            <span>Вы не зарегистрированы?</span> <a href="#register" class="fancy" data-theme="white-square">Зарегистрироваться</a>
        </div>


    </div>

</div>