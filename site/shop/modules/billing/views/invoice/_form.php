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
		<?php echo $form->labelEx($model,'invoice_time'); ?>
		<?php echo $form->textField($model,'invoice_time',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'invoice_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'invoice_amount'); ?>
		<?php echo $form->textField($model,'invoice_amount',array('size'=>12,'maxlength'=>12)); ?>
		<?php echo $form->error($model,'invoice_amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'invoice_currency'); ?>
		<?php echo $form->textField($model,'invoice_currency',array('size'=>3,'maxlength'=>3)); ?>
		<?php echo $form->error($model,'invoice_currency'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'invoice_description'); ?>
		<?php echo $form->textField($model,'invoice_description',array('size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'invoice_description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'invoice_payer_id'); ?>
		<?php echo $form->textField($model,'invoice_payer_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'invoice_payer_id'); ?>
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

	<div class="row">
		<?php echo $form->labelEx($model,'invoice_status'); ?>
		<?php echo $form->textField($model,'invoice_status'); ?>
		<?php echo $form->error($model,'invoice_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'invoice_status_time'); ?>
		<?php echo $form->textField($model,'invoice_status_time',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'invoice_status_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'invoice_paid_amount'); ?>
		<?php echo $form->textField($model,'invoice_paid_amount',array('size'=>12,'maxlength'=>12)); ?>
		<?php echo $form->error($model,'invoice_paid_amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'invoice_paid_time'); ?>
		<?php echo $form->textField($model,'invoice_paid_time',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'invoice_paid_time'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->