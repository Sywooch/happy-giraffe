<div class="login-box">
    <span class="lk">Личный кабинет</span>
    <?php echo CHtml::link('Вход', '#login', array('class' => 'fancy')); ?>
    |
    <?php echo CHtml::link('Регистрация', Yii::app()->createUrl('signup')); ?>
</div>
<div style="display:none">
    <div id="login" class="popup">

        <a href="javascript:void(0);" onclick="$.fancybox.close();" class="popup-close">Закрыть</a>

        <div class="popup-title">Вход на сайт</div>
        <?php $form = $this->beginWidget('CActiveForm', array(
                'id' => 'login-form',
                'action' => Yii::app()->createUrl('site/login'),
                'enableClientValidation' => false,
                'enableAjaxValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
            )
        ); ?>
        <div class="form">

            <div class="a-right login-btn">

                <div class="remember">
                    <?php echo $form->checkBox($model, 'remember'); ?>
                    <?php echo $form->label($model, 'remember'); ?>
                </div>

                <button class="btn btn-green-arrow-big"><span><span>Войти</span></span></button>

            </div>

            <div class="row">
                <div class="row-title">Ваш e-mail:</div>
                <div class="row-elements"><?php echo $form->textField($model, 'email'); ?></div>
                <p><?php echo $form->error($model, 'email'); ?></p>
            </div>

            <div class="row">
                <div class="row-title">Ваш пароль:</div>
                <div class="row-elements"><?php echo $form->passwordField($model, 'password'); ?></div>
                <p><?php echo $form->error($model, 'password'); ?></p>
                <div class="row-bottom"><a href="">Забыли пароль?</a></div>
            </div>

            <div class="row row-social">
                Быстрый вход:
                &nbsp;
                <?php Yii::app()->eauth->renderWidget(array('action' => 'site/login')); ?>
            </div>

            <div class="reg-link">

                <div class="a-right">
                    <a class="btn btn-orange" href="<?php echo Yii::app()->createUrl('signup'); ?>"><span><span>Зарегистрироваться</span></span></a>
                </div>

                <div class="row"><span>Еще нет учетной записи?</span></div>

            </div>

        </div>
        <?php $this->endWidget(); ?>

    </div>
</div>