<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'invoice_id'); ?>
		<?php echo $form->textField($model,'invoice_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'invoice_order_id'); ?>
		<?php echo $form->textField($model,'invoice_order_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'invoice_time'); ?>
		<?php echo $form->textField($model,'invoice_time',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'invoice_amount'); ?>
		<?php echo $form->textField($model,'invoice_amount',array('size'=>12,'maxlength'=>12)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'invoice_currency'); ?>
		<?php echo $form->textField($model,'invoice_currency',array('size'=>3,'maxlength'=>3)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'invoice_description'); ?>
		<?php echo $form->textField($model,'invoice_description',array('size'=>60,'maxlength'=>250)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'invoice_payer_id'); ?>
		<?php echo $form->textField($model,'invoice_payer_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'invoice_payer_name'); ?>
		<?php echo $form->textField($model,'invoice_payer_name',array('size'=>60,'maxlength'=>64)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'invoice_payer_email'); ?>
		<?php echo $form->textField($model,'invoice_payer_email',array('size'=>60,'maxlength'=>128)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'invoice_payer_gsm'); ?>
		<?php echo $form->textField($model,'invoice_payer_gsm',array('size'=>16,'maxlength'=>16)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'invoice_status'); ?>
		<?php echo $form->textField($model,'invoice_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'invoice_status_time'); ?>
		<?php echo $form->textField($model,'invoice_status_time',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'invoice_paid_amount'); ?>
		<?php echo $form->textField($model,'invoice_paid_amount',array('size'=>12,'maxlength'=>12)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'invoice_paid_time'); ?>
		<?php echo $form->textField($model,'invoice_paid_time',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->