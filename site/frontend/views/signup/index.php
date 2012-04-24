<?php
$css_signup = "#step_2, .members-count {display: none;}";
Yii::app()->clientScript->registerCss('signup', $css_signup)->registerScriptFile(Yii::app()->baseUrl . '/javascripts/signup.js');
?>

<div class="title">Регистрация</div>

<?php $form = $this->beginWidget('CActiveForm', array('id' => 'signup', 'action' => CController::createUrl('signup/finish', array('redirectUrl' => Yii::app()->request->getQuery('redirectUrl') ? Yii::app()->request->getQuery('redirectUrl') : '')))); ?>

    <div class="form" id="step_1">

        <div class="errors"></div>

        <div class="clearfix">
            <?php if ($regdata === null): ?>
                <div class="a-right login-social">

                    <span>Войти с помощью<br/>социальной сети</span>

                    <div class="fast-login socials socials-inline">
                        <?php Yii::app()->eauth->renderWidget(array('action' => 'signup/index')); ?>
                    </div>

                </div>

                <div class="form-in clearfix">

                    <div class="row clearfix">
                        <div class="row-title">Ваше имя:</div>
                        <div class="row-elements">
                            <?php echo $form->textField($model, 'first_name'); ?>
                            <div class="row-bottom">Укажите ваше настоящее имя, до 50 символов.</div>
                        </div>

                    </div>

                    <div class="row clearfix">
                        <div class="row-title">Ваш e-mail:</div>
                        <div class="row-elements">
                            <?php echo $form->textField($model, 'email'); ?>
                            <div class="row-bottom">Укажите реальный и действующий e-mail адрес.</div>
                        </div>

                    </div>

                    <div class="row clearfix">
                        <div class="row-title">Ваш пароль:</div>
                        <div class="row-elements">
                            <?php echo $form->passwordField($model, 'password'); ?>
                            <div class="row-bottom">Придумайте сложный пароль, который нельзя подобрать, <br/>от 6 до 12 символов — цифры и английские буквы.</div>
                        </div>

                    </div>

                    <div class="row captcha clearfix">
                        <div class="row-title">Код:</div>
                        <div class="a-right">
                            <div class="row-elements">
                                <?php echo $form->textField($model, 'verifyCode'); ?>
                                <div class="row-bottom">Введите цифры, которые Вы видите на картинке.</div>
                            </div>

                        </div>
                        <div class="row-elements">
                            <?php $this->widget('Captcha', array('showRefreshButton' => FALSE, 'selector' => '.refresh')); ?>
                            <div class="row-bottom"><a href="" class="refresh">Обновить<i class="icon"></i></a></div>
                        </div>

                    </div>

                </div>
            <?php else: ?>
                <?php echo $form->hiddenField($model, 'first_name', array('value' => $regdata['name'])); ?>

                <div class="user-info">
                    <a href="" class="ava"><?php if (isset($regdata['photo'])): ?><?php echo CHtml::image($regdata['photo']); ?><?php endif; ?></a>
                    <div class="details">
                        <a href="" class="username"><?php echo $regdata['name']; ?></a>
                    </div>
                </div>

                <div style="margin-left:200px;">
                    <div class="row clearfix">
                        <div class="row-title">Ваш e-mail:</div>
                        <div class="row-elements">
                            <?php echo $form->textField($model, 'email', array('value' => isset($regdata['email']) ? $regdata['email'] : '')); ?>
                            <div class="row-bottom">Укажите реальный и действующий e-mail адрес.</div>
                        </div>

                    </div>

                    <div class="row clearfix">
                        <div class="row-title">Ваш пароль:</div>
                        <div class="row-elements">
                            <?php echo $form->passwordField($model, 'password'); ?>
                            <div class="row-bottom">Придумайте сложный пароль, который нельзя подобрать, <br/>от 6 до 12 символов — цифры и английские буквы.</div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="form-bottom">
            <button class="btn btn-green-medium" id="next_1"><span><span>Продолжить<i class="arr-r"></i></span></span></button>
        </div>
    </div>

    <div class="form" id="step_2">

        <div class="errors"></div>

        <div class="clearfix">
            <div class="gender-select">
                <big>Вы:</big>
                <ul class="clearfix">
                    <li>
                        <a href="" class="btn btn-yellow-small" onclick="choose(0); return false;"><span><span>Выбор</span></span></a>
                        <span class="original"><img src="/images/gender_female.gif" /></span>
                        <span class="selected"><img src="/images/gender_female_selected.gif" /></span>
                        <br/>
                        <div class="info">
                            <span>Женщина</span>
                            старше 18 лет
                        </div>
                    </li>
                    <li>
                        <a href="" class="btn btn-yellow-small" onclick="choose(1); return false;"><span><span>Выбор</span></span></a>
                        <span class="original"><img src="/images/gender_male.gif" /></span>
                        <span class="selected"><img src="/images/gender_male_selected.gif" /></span>
                        <br/>
                        <div class="info">
                            <span>Мужчина</span>
                            старше 18 лет
                        </div>
                    </li>

                </ul>
                <?php echo $form->hiddenField($model, 'gender'); ?>
            </div>
            <!--<div class="members-count">
                <big>У Вас есть дети?</big>

                <ul>
                    <li>
                        <div class="img"><span class="valign"></span><img src="/images/age_01.gif" /></div>
                        <div class="age-title">ждем ребенка</div>
                        <div class="controls"><?php echo CHtml::checkBox('age_group[0]', false, array('value' => 1, 'uncheckValue' => 0)); ?></div>
                    </li>
                    <li>
                        <div class="img"><span class="valign"></span><img src="/images/age_02.gif" /></div>
                        <div class="age-title"><b>0-1</b></div>
                        <div class="controls"><a class="dec"></a><?php echo CHtml::textField('age_group[]', '0'); ?><a class="inc"></a></div>
                    </li>
                    <li>
                        <div class="img"><span class="valign"></span><img src="/images/age_03.gif" /></div>
                        <div class="age-title"><b>1-3</b></div>
                        <div class="controls"><a class="dec"></a><?php echo CHtml::textField('age_group[]', '0'); ?><a class="inc"></a></div>
                    </li>
                    <li>
                        <div class="img"><span class="valign"></span><img src="/images/age_04.gif" /></div>
                        <div class="age-title"><b>3-7</b></div>
                        <div class="controls"><a class="dec"></a><?php echo CHtml::textField('age_group[]', '0'); ?><a class="inc"></a></div>
                    </li>
                    <li>
                        <div class="img"><span class="valign"></span><img src="/images/age_05.gif" /></div>
                        <div class="age-title"><b>3-7</b></div>
                        <div class="controls"><a class="dec"></a><?php echo CHtml::textField('age_group[]', '0'); ?><a class="inc"></a></div>
                    </li>


                </ul>
            </div>-->
        </div>

        <div class="form-bottom">
            <label><input type="checkbox" id="agree" /> Я принимаю условия, изложенные в</label> <a href="">Пользовательском соглашении</a>
            <button class="btn btn-green-medium disabled" disabled="disabled" id="next_2"><span><span>Продолжить<i class="arr-r"></i></span></span></button>
        </div>
    </div>


<?php $this->endWidget(); ?>