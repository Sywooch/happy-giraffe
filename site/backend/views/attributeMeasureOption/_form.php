<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'attribute-measure-option-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'measure_id'); ?>
		<?php echo $form->dropDownList($model, 'measure_id', CHtml::listData(AttributeMeasure::model()->findAll(), 'id', 'title'), array('empty'=>' ')); ?>
		<?php echo $form->error($model,'measure_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->