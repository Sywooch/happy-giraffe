 <?php echo CHtml::link('К таблице', array('CommunityContent/admin')) ?><div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'community-content-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательны.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'updated'); ?>
		<?php echo $form->textField($model,'updated'); ?>
		<?php echo $form->error($model,'updated'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created'); ?>
		<?php echo $form->textField($model,'created'); ?>
		<?php echo $form->error($model,'created'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'author_id'); ?>
		<?php echo $form->textField($model,'author_id',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'author_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'rubric_id'); ?>
		<?php echo $form->textField($model,'rubric_id',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'rubric_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type_id'); ?>
		<?php echo $form->textField($model,'type_id',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'type_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'preview'); ?>
		<?php echo $form->textArea($model,'preview',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'preview'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'by_happy_giraffe'); ?>
		<?php echo $form->textField($model,'by_happy_giraffe'); ?>
		<?php echo $form->error($model,'by_happy_giraffe'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'removed'); ?>
		<?php echo $form->textField($model,'removed'); ?>
		<?php echo $form->error($model,'removed'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'edited'); ?>
		<?php echo $form->textField($model,'edited'); ?>
		<?php echo $form->error($model,'edited'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'editor_id'); ?>
		<?php echo $form->textField($model,'editor_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'editor_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->