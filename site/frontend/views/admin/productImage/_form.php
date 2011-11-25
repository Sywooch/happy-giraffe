<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'product-image-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array(
		'enctype'=>'multipart/form-data',
	),
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->hiddenField($model,'image_product_id'); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'image_file'); ?>
		<?php echo UFiles::fileField($model,'image_file'); ?>
		<?php echo $form->error($model,'image_file'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'image_text'); ?>
		<?php echo $form->textArea($model,'image_text',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'image_text'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->