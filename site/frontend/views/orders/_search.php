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
		<?php echo $form->label($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'number'); ?>
		<?php echo $form->textField($model,'number',array('size'=>15,'maxlength'=>15)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'item_total'); ?>
		<?php echo $form->textField($model,'item_total',array('size'=>8,'maxlength'=>8)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'total'); ?>
		<?php echo $form->textField($model,'total',array('size'=>8,'maxlength'=>8)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'created_at'); ?>
		<?php echo $form->textField($model,'created_at'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'updated_at'); ?>
		<?php echo $form->textField($model,'updated_at'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'state'); ?>
		<?php echo $form->textField($model,'state',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'adjustment_total'); ?>
		<?php echo $form->textField($model,'adjustment_total',array('size'=>8,'maxlength'=>8)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'credit_total'); ?>
		<?php echo $form->textField($model,'credit_total',array('size'=>8,'maxlength'=>8)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'completed_at'); ?>
		<?php echo $form->textField($model,'completed_at'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'bill_address_id'); ?>
		<?php echo $form->textField($model,'bill_address_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ship_address_id'); ?>
		<?php echo $form->textField($model,'ship_address_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'payment_total'); ?>
		<?php echo $form->textField($model,'payment_total',array('size'=>8,'maxlength'=>8)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'shipping_method_id'); ?>
		<?php echo $form->textField($model,'shipping_method_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'shipment_state'); ?>
		<?php echo $form->textField($model,'shipment_state',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'payment_state'); ?>
		<?php echo $form->textField($model,'payment_state',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'special_instructions'); ?>
		<?php echo $form->textArea($model,'special_instructions',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->