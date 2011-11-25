<?php
$this->breadcrumbs=array(
	'Product Types'=>array('admin'),
	$model->type_title=>array('view','id'=>$model->type_id),
	'Update',
);

$this->menu=array(
	array('label'=>'Create ProductType', 'url'=>array('create')),
	array('label'=>'View ProductType', 'url'=>array('view', 'id'=>$model->type_id)),
	array('label'=>'Manage ProductType', 'url'=>array('admin')),
);
?>

<h1><?php echo $model->type_title; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>