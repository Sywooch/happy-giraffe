<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'product-attribute-value-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
    'focus'=>array($model,'value_value'),
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'value_value'); ?>
		<?php echo $form->textField($model,'value_value',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'value_value'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->