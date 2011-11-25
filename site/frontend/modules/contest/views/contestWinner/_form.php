<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'contest-winner-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'winner_contest_id'); ?>
		<?php echo $form->textField($model,'winner_contest_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'winner_contest_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'winner_place'); ?>
		<?php echo $form->textField($model,'winner_place'); ?>
		<?php echo $form->error($model,'winner_place'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'winner_prize_id'); ?>
		<?php echo $form->textField($model,'winner_prize_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'winner_prize_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'winner_user_id'); ?>
		<?php echo $form->textField($model,'winner_user_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'winner_user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'winner_work_id'); ?>
		<?php echo $form->textField($model,'winner_work_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'winner_work_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->