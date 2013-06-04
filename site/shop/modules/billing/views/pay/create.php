<?php
$this->breadcrumbs=array(
	'Payment Create',
);

?>

<h1>Create Payment</h1>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'billing-payment-form',
	'enableAjaxValidation'=>false,
	'action'=>array('', 'invoice_id'=>$model->payment_invoice_id)
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($invoice,'invoice_description'); ?>
		<?=CHtml::encode($invoice->invoice_description)?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'payment_amount'); ?>
		<?php echo $form->textField($model,'payment_amount',array('value'=>$invoice->invoice_amount, 'size'=>12,'maxlength'=>12, 'readonly'=>1)); ?>
		<?=$invoice->invoice_currency?>
		<?php echo $form->error($model,'payment_amount'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'payment_system_id'); ?>
		<?php echo $form->dropDownList($model,'payment_system_id',
				BillingSystem::enum('system_id,system_title','system_status=1'),
				array('cols'=>40, 'maxlength'=>250)
		); ?>
		<?php echo $form->error($model,'payment_system_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? ' Pay ' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->