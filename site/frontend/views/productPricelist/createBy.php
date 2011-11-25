<?php
$this->breadcrumbs=array(
	'Product Pricelists'=>array('admin'),
	'Create By Exist',
);

$this->menu=array(
	array('label'=>'Manage ProductPricelist', 'url'=>array('admin')),
);
?>

<h1>Create ProductPricelist By Exist</h1>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'product-pricelist-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'pricelist_title'); ?>
		<?php echo $form->textField($model,'pricelist_title',array('size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'pricelist_title'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'pricelist_by'); ?>
		<?php echo $form->dropDownList($model,'pricelist_by',$model->listAll(),array(
			'empty'=>'...',
		)); ?>
		<?php echo $form->error($model,'pricelist_by'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'multiply'); ?>
		<?php echo $form->textField($model,'multiply',array('size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'multiply'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Create'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->