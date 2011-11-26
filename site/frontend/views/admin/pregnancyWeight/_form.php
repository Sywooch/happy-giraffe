<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'pregnancy-weight-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'week'); ?>
		<?php echo $form->textField($model,'week'); ?>
		<?php echo $form->error($model,'week'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'w1'); ?>
		<?php echo $form->textField($model,'w1',array('size'=>8,'maxlength'=>8)); ?>
		<?php echo $form->error($model,'w1'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'w2'); ?>
		<?php echo $form->textField($model,'w2',array('size'=>8,'maxlength'=>8)); ?>
		<?php echo $form->error($model,'w2'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'w3'); ?>
		<?php echo $form->textField($model,'w3',array('size'=>8,'maxlength'=>8)); ?>
		<?php echo $form->error($model,'w3'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->