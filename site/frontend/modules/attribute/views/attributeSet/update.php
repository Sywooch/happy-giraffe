<?php
$this->breadcrumbs=array(
	'Product Attribute Sets'=>array('admin'),
	$model->set_title=>array('view','id'=>$model->set_id),
	'Update',
);

$this->menu=array(
	array('label'=>'Create ProductAttributeSet', 'url'=>array('create')),
	array('label'=>'View ProductAttributeSet', 'url'=>array('view', 'id'=>$model->set_id)),
	array('label'=>'Manage ProductAttributeSet', 'url'=>array('admin')),
);
?>

<h1>Update ProductAttributeSet <?php echo $model->set_title; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>