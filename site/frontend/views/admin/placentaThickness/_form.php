<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'placenta-thickness-form',
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
		<?php echo $form->labelEx($model,'min'); ?>
		<?php echo $form->textField($model,'min'); ?>
		<?php echo $form->error($model,'min'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'avg'); ?>
		<?php echo $form->textField($model,'avg'); ?>
		<?php echo $form->error($model,'avg'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'max'); ?>
		<?php echo $form->textField($model,'max'); ?>
		<?php echo $form->error($model,'max'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->