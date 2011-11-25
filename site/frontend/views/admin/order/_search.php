<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'order_id'); ?>
		<?php echo $form->textField($model,'order_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'order_status'); ?>
		<?php echo $form->textField($model,'order_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'order_time'); ?>
		<?php echo $form->textField($model,'order_time',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'order_user_id'); ?>
		<?php echo $form->textField($model,'order_user_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'order_item_count'); ?>
		<?php echo $form->textField($model,'order_item_count',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'order_price'); ?>
		<?php echo $form->textField($model,'order_price',array('size'=>12,'maxlength'=>12)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'order_price_total'); ?>
		<?php echo $form->textField($model,'order_price_total',array('size'=>12,'maxlength'=>12)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'order_width'); ?>
		<?php echo $form->textField($model,'order_width',array('size'=>12,'maxlength'=>12)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'order_volume'); ?>
		<?php echo $form->textField($model,'order_volume',array('size'=>12,'maxlength'=>12)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'order_description'); ?>
		<?php echo $form->textArea($model,'order_description',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'order_vaucher_id'); ?>
		<?php echo $form->textField($model,'order_vaucher_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->