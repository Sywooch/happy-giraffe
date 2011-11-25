<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>array(
		'/contest/contestWork/'.($model->isNewRecord ? 'create' : 'update'),
		'id'=>$model->isNewRecord
			? $model->work_contest_id
			: $model->work_id,
	),
	'id'=>'contest-work-form',
	'enableAjaxValidation'=>true,
	'htmlOptions'=>array(
		'enctype'=>'multipart/form-data',
	),
)); ?>
	<?php echo $form->hiddenField($model,'work_contest_id'); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'work_title'); ?>
		<?php echo $form->textField($model,'work_title',array('size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'work_title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'work_text'); ?>
		<?php echo $form->textArea($model,'work_text',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'work_text'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'work_image'); ?>
		<?php echo $form->fileField($model,'work_image'); ?>
		<?php echo $form->error($model,'work_image'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'work_status'); ?>
		<?php echo $form->dropDownList($model,'work_status',$model->statuses->statuses); ?>
		<?php echo $form->error($model,'work_status'); ?>
		<span class="hint">Show only admin</span>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->