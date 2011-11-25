<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'map_id'); ?>
		<?php echo $form->textField($model,'map_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'map_contest_id'); ?>
		<?php echo $form->textField($model,'map_contest_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'map_object'); ?>
		<?php echo $form->textField($model,'map_object'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'map_object_id'); ?>
		<?php echo $form->textField($model,'map_object_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->