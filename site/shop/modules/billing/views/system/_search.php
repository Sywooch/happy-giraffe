<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'system_id'); ?>
		<?php echo $form->textField($model,'system_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'system_code'); ?>
		<?php echo $form->textField($model,'system_code',array('size'=>16,'maxlength'=>16)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'system_title'); ?>
		<?php echo $form->textField($model,'system_title',array('size'=>60,'maxlength'=>64)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'system_icon_file'); ?>
		<?php echo $form->textField($model,'system_icon_file',array('size'=>60,'maxlength'=>250)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'system_params'); ?>
		<?php echo $form->textArea($model,'system_params',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'system_status'); ?>
		<?php echo $form->textField($model,'system_status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->