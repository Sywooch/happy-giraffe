<?php
$this->breadcrumbs=array(
	'Product Attribute Values'=>array('index'),
	$model->value_id=>array('view','id'=>$model->value_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ProductAttributeValue', 'url'=>array('index')),
	array('label'=>'Create ProductAttributeValue', 'url'=>array('create')),
	array('label'=>'View ProductAttributeValue', 'url'=>array('view', 'id'=>$model->value_id)),
	array('label'=>'Manage ProductAttributeValue', 'url'=>array('admin')),
);
?>

<h1>Update ProductAttributeValue <?php echo $model->value_id; ?></h1>

<?php echo $this->renderPartial('/attributeValue/_form', array('model'=>$model)); ?>