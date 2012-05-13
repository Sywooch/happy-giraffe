<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title>Вход</title>

    <link href="/css/reset.css" rel="stylesheet" type="text/css"/>
    <link href="/css/general.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<div class="login">
    <h1>Вход</h1>

    <div class="form">
        <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'login-form',
        'enableAjaxValidation' => true,
    )); ?>

        <div class="row">
            <?php echo $form->labelEx($model, 'username'); ?>
            <?php echo $form->textField($model, 'username'); ?>
            <?php echo $form->error($model, 'username'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'password'); ?>
            <?php echo $form->passwordField($model, 'password'); ?>
            <?php echo $form->error($model, 'password'); ?>
        </div>

        <div class="row submit">
            <?php echo CHtml::submitButton('Войти'); ?>
        </div>

        <?php $this->endWidget(); ?>
    </div>
    <!-- form -->
</div>
</body>
</html>