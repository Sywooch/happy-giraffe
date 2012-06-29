<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Untitled Document</title>

    <?php
    Yii::app()->clientScript
        ->registerCssFile('/css/seo.css')
        ->registerCssFile('/css/my.css')
        ->registerCoreScript('jquery');
    ?>

</head>
<body>
<div id="seo" class="wrapper">

    <div id="login">

        <div class="title"><i class="img"></i><span>SEO-<span>жираф</span></span></div>

            <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'login-form',
            'enableAjaxValidation' => true,
        )); ?>
            <div class="row">
                <?php echo $form->label($model, 'username'); ?>
                <?php echo $form->textField($model, 'username'); ?>
                <?php echo $form->error($model, 'username'); ?>
            </div>
            <div class="row">
                <?php echo $form->label($model, 'password'); ?>
                <?php echo $form->passwordField($model, 'password'); ?>
                <?php echo $form->error($model, 'password'); ?>
            </div>
            <div class="row row-btn">
                <?php echo CHtml::submitButton('Войти', array('class'=>'btn-green')); ?>
            </div>

            <?php $this->endWidget(); ?>

    </div>

</div>

</body>
</html>