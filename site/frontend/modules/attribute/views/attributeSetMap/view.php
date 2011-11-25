<?php
$this->breadcrumbs=array(
	'Product Attribute Set Maps'=>array('index'),
	$model->map_id,
);

$this->menu=array(
	array('label'=>'List ProductAttributeSetMap', 'url'=>array('index')),
	array('label'=>'Create ProductAttributeSetMap', 'url'=>array('create')),
	array('label'=>'Update ProductAttributeSetMap', 'url'=>array('update', 'id'=>$model->map_id)),
	array('label'=>'Delete ProductAttributeSetMap', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->map_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ProductAttributeSetMap', 'url'=>array('admin')),
);
?>

<h1>View ProductAttributeSetMap #<?php echo $model->map_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'map_id',
		'map_set_id',
		'map_attribute_id',
		'map_attribute_title',
	),
)); ?>
