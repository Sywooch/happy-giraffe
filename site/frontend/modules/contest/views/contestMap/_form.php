<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'contest-map-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'map_contest_id'); ?>
		<?php echo $form->textField($model,'map_contest_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'map_contest_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'map_object'); ?>
		<?php echo $form->textField($model,'map_object'); ?>
		<?php echo $form->error($model,'map_object'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'map_object_id'); ?>
		<?php echo $form->textField($model,'map_object_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'map_object_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->