<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'age-range-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'range_title'); ?>
		<?php echo $form->textField($model,'range_title',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'range_title'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->