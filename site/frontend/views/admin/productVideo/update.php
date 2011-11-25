<?php
$this->breadcrumbs=array(
	'Product Videos'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ProductVideo', 'url'=>array('index')),
	array('label'=>'Create ProductVideo', 'url'=>array('create')),
	array('label'=>'View ProductVideo', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ProductVideo', 'url'=>array('admin')),
);
?>

<h1>Update ProductVideo <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>