<?php
Yii::app()->clientScript->registerCoreScript('jquery');
$model = new User;
?>
<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'pregnancy-register-form',
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
                Register.showStep2($('#User_email').val(), 'pregnancy');
            }
            return false;
          }",
    )));?>
<div class="logo-box">
    <a href="/" class="logo" title="Домашняя страница">Ключевые слова сайта</a>
    <span>САЙТ ДЛЯ ВСЕЙ СЕМЬИ</span>
</div>
<h2>Персональный календарь беременности</h2>
<div class="free">БЕСПЛАТНО!</div>
<p class="bigtext">Присоединяйтесь к сообществу будущих мам! <br /> Общайтесь, получайте советы по ведению беременности и пользуйтесь различными сервисами</p>
<p class="smalltext">Присоединяйтесь к сообществу будущих мам! <br /> Общайтесь, получайте советы по ведению беременности.</p>
<div class="row">
    <?=$form->textField($model, 'email', array('class' => 'text', 'placeholder' => 'Введите ваш e-mail адрес')); ?>
    <?=$form->error($model, 'email'); ?>
</div>
<input type="submit" value="Продолжить"  class="btn-green"/>
<div class="social-small-row clearfix">
    <em>или войти с помощью</em>
    <ul class="social-list-small">
        <?php Yii::app()->eauth->renderWidget(array('action' => 'signup/index', 'mode'=>'small', 'params'=>array('type'=>'pregnancy'))); ?>
    </ul>
</div>
<?php $this->endWidget(); ?>
<?php $this->widget('application.widgets.registerWidget.RegisterWidget', array('form_type'=>'pregnancy')); ?>