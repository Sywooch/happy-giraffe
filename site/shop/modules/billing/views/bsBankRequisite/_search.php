<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'requisite_id'); ?>
		<?php echo $form->textField($model,'requisite_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'requisite_name'); ?>
		<?php echo $form->textField($model,'requisite_name',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'requisite_account'); ?>
		<?php echo $form->textField($model,'requisite_account',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'requisite_bank'); ?>
		<?php echo $form->textField($model,'requisite_bank',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'requisite_bank_address'); ?>
		<?php echo $form->textField($model,'requisite_bank_address',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'requisite_bik'); ?>
		<?php echo $form->textField($model,'requisite_bik',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'requisite_cor_account'); ?>
		<?php echo $form->textField($model,'requisite_cor_account',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'requisite_inn'); ?>
		<?php echo $form->textField($model,'requisite_inn',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'requisite_kpp'); ?>
		<?php echo $form->textField($model,'requisite_kpp',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->