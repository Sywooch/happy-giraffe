<?php
Yii::app()->clientScript->registerCoreScript('jquery');
$model = new User;
?>
<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'reg-form',
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
                                return true;
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
            <?php Yii::app()->eauth->renderWidget(array('action' => 'signup/index', 'mode'=>'small')); ?>
        </ul>
    </div>
<?php $this->endWidget(); ?>
