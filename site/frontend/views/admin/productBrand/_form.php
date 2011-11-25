<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'product-brand-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array(
		'enctype'=>'multipart/form-data',
	),
)); ?>


	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'brand_title'); ?>
		<?php echo $form->textField($model,'brand_title',array('size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'brand_title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'brand_text'); ?>
		<?php echo $form->textArea($model,'brand_text',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'brand_text'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'brand_image'); ?>
		<?php echo UFiles::fileField($model, 'brand_image'); ?>
		<?php echo $form->error($model,'brand_image'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Редактировать'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->