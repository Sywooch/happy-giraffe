<h1>Создание рассылки</h1>

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'mailer-form',
    'enableAjaxValidation'=>false,
)); ?>
    <p>Тема письма: <input type="text" name="subject" value="" /></p>
    <p>Письмо:</p>
    <p><textarea rows="10" cols="60" name="text"></textarea></p>
    <p><input type="submit" value="Начать рассылку" /></p>
<?php $this->endWidget(); ?>