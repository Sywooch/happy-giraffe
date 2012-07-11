 <?php echo CHtml::link('К таблице', array('TestQuestionAnswer/admin')) ?><div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'test-question-answer-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательны.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'test_question_id'); ?>
		<?php echo $form->textField($model,'test_question_id'); ?>
		<?php echo $form->error($model,'test_question_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'number'); ?>
		<?php echo $form->textField($model,'number'); ?>
		<?php echo $form->error($model,'number'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'points'); ?>
		<?php echo $form->textField($model,'points'); ?>
		<?php echo $form->error($model,'points'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'text'); ?>
		<?php echo $form->textField($model,'text',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'text'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'islast'); ?>
		<?php echo $form->textField($model,'islast',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'islast'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'next_question_id'); ?>
		<?php echo $form->textField($model,'next_question_id'); ?>
		<?php echo $form->error($model,'next_question_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->