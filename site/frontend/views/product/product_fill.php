<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'product-product_fill-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'product_brand_id'); ?>
		<?php echo $form->dropDownList($model,'product_brand_id', $model->getBrands()); ?>
		<?php echo $form->error($model,'product_brand_id'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model, 'product_age_range_id'); ?>
		<?php echo $form->dropDownList($model, 'product_age_range_id', $model->getAgeRanges()); ?>
		<?php echo $form->error($model, 'product_age_range_id'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model, 'product_sex'); ?>
		<?php echo $form->dropDownList($model, 'product_sex', $model->sexList); ?>
		<?php echo $form->error($model, 'product_sex'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'product_title'); ?>
		<?php echo $form->textField($model,'product_title'); ?>
		<?php echo $form->error($model,'product_title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'product_image'); ?>
		<?php echo $form->textField($model,'product_image'); ?>
		<?php echo $form->error($model,'product_image'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'product_rate'); ?>
		<?php echo $form->textField($model,'product_rate'); ?>
		<?php echo $form->error($model,'product_rate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'product_time'); ?>
		<?php echo $form->textField($model,'product_time'); ?>
		<?php echo $form->error($model,'product_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'product_slug'); ?>
		<?php echo $form->textField($model,'product_slug'); ?>
		<?php echo $form->error($model,'product_slug'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'product_keywords'); ?>
		<?php echo $form->textField($model,'product_keywords'); ?>
		<?php echo $form->error($model,'product_keywords'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'product_description'); ?>
		<?php echo $form->textField($model,'product_description'); ?>
		<?php echo $form->error($model,'product_description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'product_text'); ?>
		<?php echo $form->textField($model,'product_text'); ?>
		<?php echo $form->error($model,'product_text'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->