<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'billing-system-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'system_id'); ?>
		<?php echo $form->textField($model,'system_id'); ?>
		<?php echo $form->error($model,'system_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'system_code'); ?>
		<?php echo $form->textField($model,'system_code',array('size'=>16,'maxlength'=>16)); ?>
		<?php echo $form->error($model,'system_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'system_title'); ?>
		<?php echo $form->textField($model,'system_title',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'system_title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'system_icon_file'); ?>
		<?php echo $form->textField($model,'system_icon_file',array('size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'system_icon_file'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'system_params'); ?>
		<?php echo $form->textArea($model,'system_params',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'system_params'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'system_status'); ?>
		<?php echo $form->textField($model,'system_status'); ?>
		<?php echo $form->error($model,'system_status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->