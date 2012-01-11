<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'test-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'start_image'); ?>
		<?php echo $form->textField($model,'start_image',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'start_image'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'css_class'); ?>
		<?php echo $form->textField($model,'css_class',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'css_class'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'text'); ?>
		<?php echo $form->textArea($model,'text',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'text'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'slug'); ?>
		<?php echo $form->textField($model,'slug',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'slug'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'result_image'); ?>
		<?php echo $form->textField($model,'result_image',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'result_image'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'result_title'); ?>
		<?php echo $form->textField($model,'result_title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'result_title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'unknown_result_image'); ?>
		<?php echo $form->textField($model,'unknown_result_image',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'unknown_result_image'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'unknown_result_text'); ?>
		<?php echo $form->textArea($model,'unknown_result_text',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'unknown_result_text'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->