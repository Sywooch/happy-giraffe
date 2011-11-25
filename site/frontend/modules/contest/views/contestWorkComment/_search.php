<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'comment_id'); ?>
		<?php echo $form->textField($model,'comment_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'comment_user_id'); ?>
		<?php echo $form->textField($model,'comment_user_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'comment_work_id'); ?>
		<?php echo $form->textField($model,'comment_work_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'comment_text'); ?>
		<?php echo $form->textArea($model,'comment_text',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'comment_status'); ?>
		<?php echo $form->textField($model,'comment_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'comment_time'); ?>
		<?php echo $form->textField($model,'comment_time',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'comment_answer'); ?>
		<?php echo $form->textArea($model,'comment_answer',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->