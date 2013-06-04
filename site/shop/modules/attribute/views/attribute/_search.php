<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'attribute_id'); ?>
		<?php echo $form->textField($model,'attribute_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'attribute_title'); ?>
		<?php echo $form->textField($model,'attribute_title',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'attribute_text'); ?>
		<?php echo $form->textArea($model,'attribute_text',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'attribute_type'); ?>
		<?php echo $form->textField($model,'attribute_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'attribute_required'); ?>
		<?php echo $form->textField($model,'attribute_required'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'attribute_is_insearch'); ?>
		<?php echo $form->textField($model,'attribute_is_insearch'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->