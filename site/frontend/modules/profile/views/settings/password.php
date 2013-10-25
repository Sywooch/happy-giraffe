<?php
/**
 * @var $form
 */

$form = $this->beginWidget('CActiveForm') ?>

<div class="margin-b20 clearfix">
    <div class="form-settings_label">Текущий пароль</div>
    <div class="form-settings_elem">
        <div class="w-300">
            <?=$form->passwordField($this->user, 'current_password', array('class' => 'itx-gray')); ?>
            <?=$form->error($this->user, 'current_password') ?>
        </div>
    </div>
</div>
<div class="margin-b20 clearfix">
    <div class="form-settings_label">Новый пароль</div>
    <div class="form-settings_elem">
        <div class="w-300">
            <?=$form->passwordField($this->user, 'new_password', array('class' => 'itx-gray')); ?>
            <?=$form->error($this->user, 'new_password') ?>
        </div>
        <div class="form-settings_desc w-300">Придумайте сложный пароль, котрый нельзя подобрать, от 6 до 12 символов - цифры и английские буквы.</div>
    </div>
</div>
<div class="margin-b40 clearfix">
    <div class="form-settings_label">Повторите новый пароль</div>
    <div class="form-settings_elem">
        <div class="w-300">
            <?=$form->passwordField($this->user, 'new_password_repeat', array('class' => 'itx-gray')); ?>
            <?=$form->error($this->user, 'new_password_repeat') ?>
        </div>
    </div>
</div>
<div class="margin-b20 clearfix">
    <div class="form-settings_label">Код</div>
    <div class="form-settings_elem">
        <div class="float-l w-130 margin-r10">
            <div class="form-settings_capcha">
                <!-- Размеры капчи 128*45 -->
                <?php $this->widget('Captcha', array('showRefreshButton' => FALSE, 'selector' => '.ico-refresh')); ?>
            </div>
            <div class="form-settings_desc">
                Обновить картинку
                <a href="" class="ico-refresh"></a>
            </div>
        </div>
        <div class="float-l">
            <div class="w-160 margin-t15">
                <?=$form->textField($this->user, 'verifyCode', array('class' => 'itx-gray')); ?>
                <?=$form->error($this->user, 'verifyCode') ?>
            </div>
            <div class="form-settings_desc">Введите цифры, которые вы видите на картинке.</div>
        </div>
    </div>
</div>
<div class="margin-b20 clearfix">
    <div class="form-settings_label">&nbsp;</div>
    <div class="form-settings_elem">
        <button class="btn-blue btn-medium">Изменить</button>
        <?php if(Yii::app()->user->hasFlash('success')):?>
            <span class="msg-win display-ib margin-l20">Пароль успешно изменён</span>
            <?php Yii::app()->clientScript->registerScript('hideEffect', '$(".msg-win").animate({opacity: 1.0}, 3000).fadeOut("slow");');?>
        <?php endif; ?>
    </div>
</div>
<?php $this->endWidget(); ?>