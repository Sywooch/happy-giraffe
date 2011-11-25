<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'vaucher_id'); ?>
		<?php echo $form->textField($model,'vaucher_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'vaucher_code'); ?>
		<?php echo $form->textField($model,'vaucher_code',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'vaucher_discount'); ?>
		<?php echo $form->textField($model,'vaucher_discount',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'vaucher_time'); ?>
		<?php echo $form->textField($model,'vaucher_time',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'vaucher_from_time'); ?>
		<?php echo $form->textField($model,'vaucher_from_time',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'vaucher_till_time'); ?>
		<?php echo $form->textField($model,'vaucher_till_time',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'vaucher_text'); ?>
		<?php echo $form->textArea($model,'vaucher_text',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->