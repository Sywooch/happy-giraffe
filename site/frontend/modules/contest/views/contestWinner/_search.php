<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'winner_id'); ?>
		<?php echo $form->textField($model,'winner_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'winner_contest_id'); ?>
		<?php echo $form->textField($model,'winner_contest_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'winner_place'); ?>
		<?php echo $form->textField($model,'winner_place'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'winner_prize_id'); ?>
		<?php echo $form->textField($model,'winner_prize_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'winner_user_id'); ?>
		<?php echo $form->textField($model,'winner_user_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'winner_work_id'); ?>
		<?php echo $form->textField($model,'winner_work_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->