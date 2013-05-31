<?php
$this->breadcrumbs=array(
	'Billing Invoices'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List BillingInvoice', 'url'=>array('index')),
	array('label'=>'Manage BillingInvoice', 'url'=>array('admin')),
);
?>

<h1>Create BillingInvoice</h1>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'billing-invoice-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'invoice_order_id'); ?>
		<?php echo $form->textField($model,'invoice_order_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'invoice_order_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'invoice_amount'); ?>
		<?php echo $form->textField($model,'invoice_amount',array('size'=>12,'maxlength'=>12)); ?>
		<?php echo $form->error($model,'invoice_amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'invoice_currency'); ?>
		<?php echo $form->dropDownList($model,'invoice_currency',array('RUR'=>'RUR')); ?>
		<?php echo $form->error($model,'invoice_currency'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'invoice_description'); ?>
		<?php echo $form->textArea($model,'invoice_description',array('cols'=>40, 'maxlength'=>250)); ?>
		<?php echo $form->error($model,'invoice_description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'invoice_payer_name'); ?>
		<?php echo $form->textField($model,'invoice_payer_name',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'invoice_payer_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'invoice_payer_email'); ?>
		<?php echo $form->textField($model,'invoice_payer_email',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'invoice_payer_email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'invoice_payer_gsm'); ?>
		<?php echo $form->textField($model,'invoice_payer_gsm',array('size'=>16,'maxlength'=>16)); ?>
		<?php echo $form->error($model,'invoice_payer_gsm'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->