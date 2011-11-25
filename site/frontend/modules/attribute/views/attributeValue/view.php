<?php
$this->breadcrumbs=array(
	'Product Attribute Values'=>array('index'),
	$model->value_id,
);

$this->menu=array(
	array('label'=>'List ProductAttributeValue', 'url'=>array('index')),
	array('label'=>'Create ProductAttributeValue', 'url'=>array('create')),
	array('label'=>'Update ProductAttributeValue', 'url'=>array('update', 'id'=>$model->value_id)),
	array('label'=>'Delete ProductAttributeValue', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->value_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ProductAttributeValue', 'url'=>array('admin')),
);
?>

<h1>View ProductAttributeValue #<?php echo $model->value_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'value_id',
		'value_value',
	),
)); ?>
