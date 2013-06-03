<?php
$this->breadcrumbs=array(
	'Product Attribute Value Maps'=>array('index'),
	$model->map_id=>array('view','id'=>$model->map_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ProductAttributeValueMap', 'url'=>array('index')),
	array('label'=>'Create ProductAttributeValueMap', 'url'=>array('create')),
	array('label'=>'View ProductAttributeValueMap', 'url'=>array('view', 'id'=>$model->map_id)),
	array('label'=>'Manage ProductAttributeValueMap', 'url'=>array('admin')),
);
?>

<h1>Update ProductAttributeValueMap <?php echo $model->map_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>