<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'orders-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id'); ?>
		<?php echo $form->error($model,'user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'number'); ?>
		<?php echo $form->textField($model,'number',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'number'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'item_total'); ?>
		<?php echo $form->textField($model,'item_total',array('size'=>8,'maxlength'=>8)); ?>
		<?php echo $form->error($model,'item_total'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'total'); ?>
		<?php echo $form->textField($model,'total',array('size'=>8,'maxlength'=>8)); ?>
		<?php echo $form->error($model,'total'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created_at'); ?>
		<?php echo $form->textField($model,'created_at'); ?>
		<?php echo $form->error($model,'created_at'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'updated_at'); ?>
		<?php echo $form->textField($model,'updated_at'); ?>
		<?php echo $form->error($model,'updated_at'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'state'); ?>
		<?php echo $form->textField($model,'state',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'state'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'adjustment_total'); ?>
		<?php echo $form->textField($model,'adjustment_total',array('size'=>8,'maxlength'=>8)); ?>
		<?php echo $form->error($model,'adjustment_total'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'credit_total'); ?>
		<?php echo $form->textField($model,'credit_total',array('size'=>8,'maxlength'=>8)); ?>
		<?php echo $form->error($model,'credit_total'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'completed_at'); ?>
		<?php echo $form->textField($model,'completed_at'); ?>
		<?php echo $form->error($model,'completed_at'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'bill_address_id'); ?>
		<?php echo $form->textField($model,'bill_address_id'); ?>
		<?php echo $form->error($model,'bill_address_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ship_address_id'); ?>
		<?php echo $form->textField($model,'ship_address_id'); ?>
		<?php echo $form->error($model,'ship_address_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'payment_total'); ?>
		<?php echo $form->textField($model,'payment_total',array('size'=>8,'maxlength'=>8)); ?>
		<?php echo $form->error($model,'payment_total'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'shipping_method_id'); ?>
		<?php echo $form->textField($model,'shipping_method_id'); ?>
		<?php echo $form->error($model,'shipping_method_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'shipment_state'); ?>
		<?php echo $form->textField($model,'shipment_state',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'shipment_state'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'payment_state'); ?>
		<?php echo $form->textField($model,'payment_state',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'payment_state'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'special_instructions'); ?>
		<?php echo $form->textArea($model,'special_instructions',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'special_instructions'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->