<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'prize_id'); ?>
		<?php echo $form->textField($model,'prize_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'prize_contest_id'); ?>
		<?php echo $form->textField($model,'prize_contest_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'prize_place'); ?>
		<?php echo $form->textField($model,'prize_place'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'prize_item_id'); ?>
		<?php echo $form->textField($model,'prize_item_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'prize_text'); ?>
		<?php echo $form->textArea($model,'prize_text',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->