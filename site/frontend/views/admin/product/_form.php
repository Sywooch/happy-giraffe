<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'product-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array(
		'enctype'=>'multipart/form-data',
	),
)); ?>

	<?php echo $form->errorSummary($model); ?>
	<?php echo $form->hiddenField($model,'product_category_id'); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'product_articul'); ?>
		<?php echo $form->textField($model,'product_articul',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'product_articul'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'product_title'); ?>
		<?php echo $form->textField($model,'product_title',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'product_title'); ?>
	</div>
	
    <div class="row">
		<?php echo $form->labelEx($model, 'product_brand_id'); ?>
		<?php echo $form->dropDownList($model, 'product_brand_id', $model->getBrands(), array(
			'empty'=>'--',
		)); ?>
		<?php echo $form->error($model, 'product_brand_id'); ?>
	</div>
	
    <div class="row">
		<?php echo $form->labelEx($model, 'product_age_range_id'); ?>
		<?php echo $form->dropDownList($model, 'product_age_range_id', $model->getAgeRanges(), array(
			'empty'=>'--',
		)); ?>
		<?php echo $form->error($model, 'product_age_range_id'); ?>
	</div>
	
    <div class="row">
		<?php echo $form->labelEx($model, 'product_sex'); ?>
		<?php echo $form->dropDownList($model, 'product_sex', $model->sexList, array(
			'empty'=>'--',
		)); ?>
		<?php echo $form->error($model, 'product_sex'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'product_text'); ?>
		<?php echo $form->textArea($model,'product_text',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'product_text'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'product_price'); ?>
		<?php echo $form->textField($model,'product_price',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'product_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'product_buy_price'); ?>
		<?php echo $form->textField($model,'product_buy_price',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'product_buy_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'product_sell_price'); ?>
		<?php echo $form->textField($model,'product_sell_price',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'product_sell_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'product_image'); ?>
		<?php echo UFiles::fileField($model,'product_image'); ?>
		<?php echo $form->error($model,'product_image'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'product_keywords'); ?>
		<?php echo $form->textField($model,'product_keywords',array('size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'product_keywords'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'product_description'); ?>
		<?php echo $form->textField($model,'product_description',array('size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'product_description'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'product_status'); ?>
		<?php echo $form->dropDownList($model,'product_status',$model->statuses->statuses); ?>
		<?php echo $form->error($model,'product_status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Редактировать'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->