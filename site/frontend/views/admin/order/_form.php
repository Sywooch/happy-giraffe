<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'order-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'order_status'); ?>
		<?php echo $form->textField($model,'order_status'); ?>
		<?php echo $form->error($model,'order_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'order_time'); ?>
		<?php echo $form->textField($model,'order_time',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'order_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'order_user_id'); ?>
		<?php echo $form->textField($model,'order_user_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'order_user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'order_item_count'); ?>
		<?php echo $form->textField($model,'order_item_count',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'order_item_count'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'order_price'); ?>
		<?php echo $form->textField($model,'order_price',array('size'=>12,'maxlength'=>12)); ?>
		<?php echo $form->error($model,'order_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'order_price_total'); ?>
		<?php echo $form->textField($model,'order_price_total',array('size'=>12,'maxlength'=>12)); ?>
		<?php echo $form->error($model,'order_price_total'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'order_width'); ?>
		<?php echo $form->textField($model,'order_width',array('size'=>12,'maxlength'=>12)); ?>
		<?php echo $form->error($model,'order_width'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'order_volume'); ?>
		<?php echo $form->textField($model,'order_volume',array('size'=>12,'maxlength'=>12)); ?>
		<?php echo $form->error($model,'order_volume'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'order_description'); ?>
		<?php echo $form->textArea($model,'order_description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'order_description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'order_vaucher_id'); ?>
		<?php echo $form->textField($model,'order_vaucher_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'order_vaucher_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->