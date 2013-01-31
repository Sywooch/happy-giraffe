<?php
    $cs = Yii::app()->clientScript;

    $js = '
        Settings.entity = ' . CJavaScript::encode(get_class($this->user)) . ';
        Settings.entity_id = ' . CJavaScript::encode($this->user->id) . ';
    ';

    $cs
        ->registerScript('settings_popup', $js)
    ;
?>
<div id="user-settings" class="clearfix">

    <div class="header">

        <div class="title">
            <span>Мои настройки</span>
        </div>

        <div class="nav">
            <ul>
                <li><a href="javascript:void(0)" onclick="Settings.openTab(0)">Личные данные</a></li>
                <li><a href="javascript:void(0)" onclick="Settings.openTab(1)">Социальные сети</a></li>
                <li><a href="javascript:void(0)" onclick="Settings.openTab(2)">Пароль</a></li>
            </ul>
        </div>

        <a href="javascript:void(0)" onclick="Settings.close()" class="close">Закрыть настройки</a>

    </div>

    <div class="settings">

        <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
            'user' => $this->user,
            'small' => true,
        )) ; ?>

        <div class="settings-in" style="display: none;">

            <div class="settings-form">

                <?php $this->renderPartial('_input', array(
                    'model' => $this->user,
                    'attribute' => 'first_name',
                    'big' => true,
                )); ?>

                <?php $this->renderPartial('_input', array(
                    'model' => $this->user,
                    'attribute' => 'last_name',
                    'big' => true,
                )); ?>

                <div class="row clearfix">

                    <div class="row-title">Дата рождения:</div>

                    <div class="row-elements">
                        <div class="value"<?php if (! $this->user->birthday): ?> style="display: none;"<?php endif; ?>>
                            <span class="value"><?=Yii::app()->dateFormatter->format("d MMMM", $this->user->birthday)?> (<?=$this->user->normalizedAge?>)</span>
                            <a href="javascript:void(0)" onclick="Settings.showInput(this)" class="edit tooltip" title="Изменить"></a>
                        </div>

                        <div class="input"<?php if ($this->user->birthday): ?> style="display: none;"<?php endif; ?>>
                            <?php
                                $this->widget('DateWidget', array(
                                    'model' => $this->user,
                                    'attribute' => 'birthday',
                                    'first_year'=>18
                                ));
                            ?>
                            <button onclick="Settings.saveBirthday(this)" class="btn-green small">Ok</button>
                        </div>
                    </div>

                </div>

                <div class="row clearfix">

                    <div class="row-title">Пол:</div>

                    <div class="row-elements">
                        <?=CHtml::activeRadioButton($this->user, 'gender', array('value' => 0, 'onclick' => 'Settings.changeGender(this)'))?>
                        <label>Женщина</label>
                        &nbsp;
                        <?=CHtml::activeRadioButton($this->user, 'gender', array('value' => 1, 'onclick' => 'Settings.changeGender(this)'))?>
                        <label>Мужчина</label>
                    </div>

                </div>

                <?php $this->renderPartial('_input', array(
                    'model' => $this->user,
                    'attribute' => 'email',
                    'big' => false,
                )); ?>

                <div class="row clearfix">

                    <div class="row-title">Участник</div>

                    <div class="row-elements">
                        с <?=Yii::app()->dateFormatter->format("dd MMMM yyyy", $this->user->register_date)?>
                    </div>

                </div>

                <div class="row clearfix">

                    <div class="row-title">Удалить анкету:</div>

                    <div class="row-elements">
                        <p>Да, я хочу <?php echo CHtml::link('Удалить анкету', array('remove'), array('class' => 'delete', 'confirm' => 'Вы действительно хотите удалить анкету?')) ?>, потеряв всю введенную информацию
                            без возможности восстановления.</p>
                    </div>

                </div>

                <div class="row clearfix">

                    <?=CHtml::activeCheckBox($this->user->getMailSubs(), 'weekly_news', array('onclick' => 'Settings.changeMailSub(this, "weekly_news")'))?>
                    <label>Хочу получать еженедельные новости от Веселого Жирафа</label>

                </div>

            </div>

        </div>

        <div class="settings-in" style="display: none;">

            <div class="socials">

                <p>Свяжите свой профиль с вашими аккаунтами на других сайтах. <br/>Это позволит входить на сайт, используя любой из привязанных аккаунтов.</p>

                <?php Yii::app()->eauth->renderWidget(array('mode' => 'profile', 'action' => 'site/login', 'predefinedServices' => array('odnoklassniki', 'mailru', 'facebook', 'vkontakte'))); ?>

            </div>

        </div>

        <div class="settings-in" style="display: none;">

            <div class="settings-form password-form">

                <?php $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'password-form',
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                        'validateOnChange' => false,
                        'afterValidate' => 'js:function(form, data, hasError) {if (! hasError) Settings.changePassword(form);}',
                    ),
                    'action' => array('changePassword'),
                ));?>

                    <div class="row clearfix">

                        <div class="row-title">Текущий пароль:</div>

                        <div class="row-elements">
                            <?=$form->passwordField($this->user, 'current_password', array('class' => 'input-big'))?><br/>
                            <?=$form->error($this->user, 'current_password')?>
                        </div>

                    </div>

                    <div class="row clearfix">

                        <div class="row-title">Новый пароль:</div>

                        <div class="row-elements">
                            <?=$form->passwordField($this->user, 'new_password', array('class' => 'input-big'))?><br/>
                            <?=$form->error($this->user, 'new_password')?>
                            <div class="small">Придумайте сложный пароль, который нельзя подобрать,<br />от 6 до 16 символов.</div>
                        </div>

                    </div>

                    <div class="row clearfix">

                        <div class="row-title">Новый пароль<br/>еще раз:</div>

                        <div class="row-elements">
                            <?=$form->passwordField($this->user, 'new_password_repeat', array('class' => 'input-big'))?>
                            <?=$form->error($this->user, 'new_password_repeat')?>
                        </div>

                    </div>

                    <div class="row clearfix row-captcha">

                        <div class="row-title">Код:</div>

                        <div class="row-elements">

                            <div class="col">
                                <div class="captcha-img"><?php $this->widget('Captcha', array('showRefreshButton' => FALSE, 'selector' => '.refresh')); ?></div>
                                <a href="javascript:void(0)" class="refresh">Обновить картинку<i class="icon"></i></a>
                            </div>

                            <div class="col">
                                <?=$form->textField($this->user, 'verifyCode', array('class' => 'input-big'))?><br/>
                                <?=$form->error($this->user, 'verifyCode')?>
                                <div class="small">Введите цифры, которые Вы видите на картинке.</div>
                            </div>

                        </div>

                    </div>

                    <div class="row clearfix row-captcha">

                        <div class="row-title">&nbsp;</div>

                        <div class="row-elements">

                            <button class="btn-orange">Изменить</button>
                            <span class="success" style="display: none;">Пароль успешно изменён</span>

                        </div>

                    </div>

                <?php $this->endWidget(); ?>

            </div>

        </div>

    </div>

</div>