<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'product-attribute-set-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'set_title'); ?>
		<?php echo $form->textField($model,'set_title',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'set_title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'set_text'); ?>
		<?php echo $form->textArea($model,'set_text',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'set_text'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->