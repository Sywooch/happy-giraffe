<?php
/* @var $form CActiveForm
 * @var MailCampaign $model
 */
?>
<h1>Создание рассылки</h1>

<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'mailer-form',
    'enableAjaxValidation' => false,
)); ?>
<p>Тема письма: <?php echo $form->textField($model, 'subject', array('maxlength' => 100)); ?></p>
<p>Письмо:</p>
<p>
    <?php echo $form->textArea($model, 'body', array('rows' => 10, 'cols' => 40)); ?>
</p>
<p><input type="submit" value="Начать рассылку"/></p>
<?php $this->endWidget(); ?>