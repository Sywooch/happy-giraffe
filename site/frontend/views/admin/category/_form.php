<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'category-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'category_name'); ?>
		<?php echo $form->textField($model,'category_name',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'category_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'category_title'); ?>
		<?php echo $form->textField($model,'category_title',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'category_title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'category_text'); ?>
		<?php echo $form->textArea($model,'category_text',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'category_text'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'category_keywords'); ?>
		<?php echo $form->textField($model,'category_keywords',array('size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'category_keywords'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'category_description'); ?>
		<?php echo $form->textField($model,'category_description',array('size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'category_description'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->