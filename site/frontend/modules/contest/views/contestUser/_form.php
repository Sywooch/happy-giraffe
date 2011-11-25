<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'contest-user-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'user_user_id'); ?>
		<?php echo $form->textField($model,'user_user_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'user_user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_contest_id'); ?>
		<?php echo $form->textField($model,'user_contest_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'user_contest_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_work_count'); ?>
		<?php echo $form->textField($model,'user_work_count'); ?>
		<?php echo $form->error($model,'user_work_count'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->