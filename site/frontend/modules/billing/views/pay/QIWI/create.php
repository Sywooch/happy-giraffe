<?php
$this->breadcrumbs=array(
	'QIWI',
);


?>

<h1>QIWI Платёж</h1>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'billing-system-form',
	'enableAjaxValidation'=>false,
));
?>
<input type="hidden" name="payment_id" value="<?=$payment->payment_id?>">

	<p class="note">Поля помеченные <span class="required">*</span> обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>


	<div class="row">
		<?php echo $form->labelEx($model,'form_gsm'); ?>
		<?php echo $form->textField($model,'form_gsm',array('size'=>16,'maxlength'=>16)); ?>
		<?php echo $form->error($model,'form_gsm'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton(' Оплатить '); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->