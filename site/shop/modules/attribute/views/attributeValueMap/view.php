<?php
$this->breadcrumbs=array(
	'Product Attribute Value Maps'=>array('index'),
	$model->map_id,
);

$this->menu=array(
	array('label'=>'List ProductAttributeValueMap', 'url'=>array('index')),
	array('label'=>'Create ProductAttributeValueMap', 'url'=>array('create')),
	array('label'=>'Update ProductAttributeValueMap', 'url'=>array('update', 'id'=>$model->map_id)),
	array('label'=>'Delete ProductAttributeValueMap', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->map_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ProductAttributeValueMap', 'url'=>array('admin')),
);
?>

<h1>View ProductAttributeValueMap #<?php echo $model->map_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'map_id',
		'map_attribute_id',
		'map_value_id',
	),
)); ?>
