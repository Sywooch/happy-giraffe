<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>array('/order/create'),
	'id'=>'order-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'order_description'); ?>
		<?php echo $form->textArea($model,'order_description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'order_description'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->