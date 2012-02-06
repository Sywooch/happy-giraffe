<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'age-range-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательны.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'range_title'); ?>
		<?php echo $form->textField($model,'range_title',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'range_title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'range_order'); ?>
		<?php echo $form->textField($model,'range_order',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'range_order'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->