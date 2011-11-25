<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'contest_id'); ?>
		<?php echo $form->textField($model,'contest_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'contest_title'); ?>
		<?php echo $form->textField($model,'contest_title',array('size'=>60,'maxlength'=>250)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'contest_text'); ?>
		<?php echo $form->textArea($model,'contest_text',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'contest_image'); ?>
		<?php echo $form->textField($model,'contest_image',array('size'=>60,'maxlength'=>250)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'contest_from_time'); ?>
		<?php echo $form->textField($model,'contest_from_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'contest_till_time'); ?>
		<?php echo $form->textField($model,'contest_till_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'contest_status'); ?>
		<?php echo $form->textField($model,'contest_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'contest_time'); ?>
		<?php echo $form->textField($model,'contest_time',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'contest_user_id'); ?>
		<?php echo $form->textField($model,'contest_user_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->