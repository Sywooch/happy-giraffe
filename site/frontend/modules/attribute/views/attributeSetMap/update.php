<?php
$this->breadcrumbs=array(
	'Product Attribute Set Maps'=>array('admin'),
	$model->map_attribute_title=>array('view','id'=>$model->map_id),
	'Update',
);

$this->menu=array(
	array('label'=>'Create ProductAttributeSetMap', 'url'=>array('create')),
	array('label'=>'View ProductAttributeSetMap', 'url'=>array('view', 'id'=>$model->map_id)),
	array('label'=>'Manage ProductAttributeSetMap', 'url'=>array('admin')),
);
?>

<h1>Update ProductAttributeSetMap <?php echo $model->map_attribute_title; ?></h1>

<?php
echo $this->renderPartial('/attributeSetMap/_form', array(
	'model'=>$model,
	'attributes'=>$attributes,
));
?>