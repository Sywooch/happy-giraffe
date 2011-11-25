<?php
$this->breadcrumbs=array(
	'Product Attributes'=>array('index'),
	$model->attribute_id=>array('view','id'=>$model->attribute_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ProductAttribute', 'url'=>array('index')),
	array('label'=>'Create ProductAttribute', 'url'=>array('create')),
	array('label'=>'View ProductAttribute', 'url'=>array('view', 'id'=>$model->attribute_id)),
	array('label'=>'Manage ProductAttribute', 'url'=>array('admin')),
);
?>

<h1>Update ProductAttribute <?php echo $model->attribute_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>