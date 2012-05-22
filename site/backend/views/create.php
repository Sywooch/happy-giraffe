<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'cook-ingredients-nutritionals-create-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'ingredient_id'); ?>
		<?php echo $form->textField($model,'ingredient_id'); ?>
		<?php echo $form->error($model,'ingredient_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nutritional_id'); ?>
		<?php echo $form->textField($model,'nutritional_id'); ?>
		<?php echo $form->error($model,'nutritional_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'value'); ?>
		<?php echo $form->textField($model,'value'); ?>
		<?php echo $form->error($model,'value'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->