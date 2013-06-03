<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'product-attribute-value-map-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'map_attribute_id'); ?>
		<?php echo $form->textField($model,'map_attribute_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'map_attribute_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'map_value_id'); ?>
		<?php echo $form->textField($model,'map_value_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'map_value_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->