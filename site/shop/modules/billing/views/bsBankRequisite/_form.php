<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'billing-system-bankrequisite-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'requisite_name'); ?>
		<?php echo $form->textField($model,'requisite_name',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'requisite_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'requisite_account'); ?>
		<?php echo $form->textField($model,'requisite_account',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'requisite_account'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'requisite_bank'); ?>
		<?php echo $form->textField($model,'requisite_bank',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'requisite_bank'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'requisite_bank_address'); ?>
		<?php echo $form->textField($model,'requisite_bank_address',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'requisite_bank_address'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'requisite_bik'); ?>
		<?php echo $form->textField($model,'requisite_bik',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'requisite_bik'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'requisite_cor_account'); ?>
		<?php echo $form->textField($model,'requisite_cor_account',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'requisite_cor_account'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'requisite_inn'); ?>
		<?php echo $form->textField($model,'requisite_inn',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'requisite_inn'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'requisite_kpp'); ?>
		<?php echo $form->textField($model,'requisite_kpp',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'requisite_kpp'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->