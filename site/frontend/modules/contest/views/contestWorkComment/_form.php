<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'contest-work-comment-form',
	'enableAjaxValidation'=>true,
)); ?>
	<?php echo $form->hiddenField($model,'comment_work_id'); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'comment_text'); ?>
		<?php echo $form->textArea($model,'comment_text',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'comment_text'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'comment_status'); ?>
		<?php echo $form->dropDownList($model,'comment_status',$model->statuses->statuses); ?>
		<?php echo $form->error($model,'comment_status'); ?>
		<span class="hint">Show only admin</span>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'comment_answer'); ?>
		<?php echo $form->textArea($model,'comment_answer',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'comment_answer'); ?>
		<span class="hint">Show only admin</span>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->