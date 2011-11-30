<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'week'); ?>
		<?php echo $form->textField($model,'week'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'min'); ?>
		<?php echo $form->textField($model,'min'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'avg'); ?>
		<?php echo $form->textField($model,'avg'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'max'); ?>
		<?php echo $form->textField($model,'max'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->