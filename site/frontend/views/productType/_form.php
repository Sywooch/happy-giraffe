<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'product-type-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array(
		'enctype'=>'multipart/form-data',
	),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'type_title'); ?>
		<?php echo $form->textField($model,'type_title',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'type_title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type_text'); ?>
		<?php echo $form->textArea($model,'type_text',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'type_text'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type_image'); ?>
		<?php echo UFiles::fileField($model,'type_image'); ?>
		<?php echo $form->error($model,'type_image'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type_attribute_set_id'); ?>
		<?php echo $form->dropDownList($model,'type_attribute_set_id',$model->getAllSets()); ?>
		<?php echo $form->error($model,'type_attribute_set_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->