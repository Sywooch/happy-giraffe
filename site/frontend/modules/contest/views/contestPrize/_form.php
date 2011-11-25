<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>array(
		'/contest/contestPrize/'.($model->isNewRecord ? 'create' : 'update'),
		'id'=>$model->isNewRecord
			? $model->prize_contest_id
			: $model->prize_id,
	),
	'id'=>'contest-prize-form',
	'enableAjaxValidation'=>true,
)); ?>
	<?php echo $form->hiddenField($model,'prize_contest_id'); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'prize_place'); ?>
		<?php echo $form->textField($model,'prize_place'); ?>
		<?php echo $form->error($model,'prize_place'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'prize_item_id'); ?>
		<?php echo $form->textField($model,'prize_item_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'prize_item_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'prize_text'); ?>
		<?php echo $form->textArea($model,'prize_text',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'prize_text'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->