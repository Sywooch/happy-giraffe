<?php
$this->breadcrumbs=array(
	'Products'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Product', 'url'=>array('index')),
	array('label'=>'Manage Product', 'url'=>array('admin')),
);
?>

<h1>Create Product</h1>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'product-product_category-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'product_category_id'); ?>
		<?php echo $form->dropDownList($model,'product_category_id',Category::model()->listAll(),array(
			'empty'=>'Select one',
		)); ?>
		<?php echo $form->error($model,'product_category_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Next'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->