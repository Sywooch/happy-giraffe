<div id="start">
    <div class="wrapper">
        <div id="start-form">
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
                <div class="form-title">Вход на сайт</div>
                <div class="row">
                    <div class="row-title">Ваш e-mail:</div>

                    <div class="row-elements">
                        <?php echo $form->textField($model, 'email'); ?>
                    </div>
                    <?php echo $form->error($model, 'email'); ?>
                </div>
                <div class="row">
                    <div class="row-title">Ваш пароль:</div>
                    <div class="row-elements">
                        <?php echo $form->passwordField($model, 'password'); ?>
                    </div>
                    <?php echo $form->error($model, 'password'); ?>
                </div>
                <div class="row">
                    <button class="btn btn-green-medium a-right"><span><span>Войти<i class="arr-r"></i></span></span></button>
                    <label><?php echo $form->checkBox($model, 'remember'); ?> Запомнить меня</label>
                </div>
                <br/>
                <div class="fast-login socials socials-inline">
                    Быстрый вход:&nbsp;
                    &nbsp;
                    <?php Yii::app()->eauth->renderWidget(array('action' => '/site/login')); ?>
                </div>
                <br/>
                <div class="question">Еще нет учетной записи?</div>
                <center><a href="<?php echo Yii::app()->createUrl('signup'); ?>" class="btn btn-orange"><span><span>Зарегистрироваться</span></span></a></center>
            <?php $this->endWidget(); ?>
        </div>

    </div>
</div>

<div id="start-teasers" class="wrapper">

    <ul class="clearfix">
        <li>
            <big>Общайся в <span>Клубах</span></big>
            <div class="img"><img src="/images/teaser_img_01.png" /></div>
            <div class="text">Вступай в клубы, находи друзей и общайся на различные темы</div>
        </li>

        <li>
            <big>Участвуй в <span class="green">Конкурсах</span></big>
            <div class="img"><img src="/images/teaser_img_02.png" /></div>
            <div class="text">Используй возможность выиграть отличные призы</div>
        </li>
        <li>
            <big>Пользуйся <span class="blue">Сервисами</span></big>

            <div class="img"><img src="/images/teaser_img_03.png" /></div>
            <div class="text">Самые полезные сервисы на все случаи жизни</div>
        </li>
        <li>
            <big>Набирай <span class="orange">Баллы</span></big>
            <div class="img"><img src="/images/teaser_img_04.png" /></div>
            <div class="text">Получай виртуальные и реальные бонусы</div>

        </li>

    </ul>

</div>

<div id="footer" class="wrapper clearfix" style="margin-top:0;">

    <div class="a-right">
        <a href="javascript:;">Политика конфедециальности</a> &nbsp; | &nbsp; <a href="javascript:;">Пользовательское соглашение</a>

    </div>

    <div class="copy">
        <p>Весёлый жираф &nbsp; © 2012 &nbsp; Все права защищены</p>
    </div>

</div>