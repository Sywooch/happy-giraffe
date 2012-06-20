 <?php echo CHtml::link('К таблице', array('CookUnit/admin')) ?><div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'cook-unit-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательны.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'title2'); ?>
		<?php echo $form->textField($model,'title2',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title2'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'title3'); ?>
		<?php echo $form->textField($model,'title3',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title3'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ratio'); ?>
		<?php echo $form->textField($model,'ratio',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'ratio'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->