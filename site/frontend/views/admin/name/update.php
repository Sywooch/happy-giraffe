<?php
$this->breadcrumbs=array(
	'Names'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Name', 'url'=>array('index')),
	array('label'=>'Create Name', 'url'=>array('create')),
	array('label'=>'View Name', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Name', 'url'=>array('admin')),
);
?>

<h1>Update Name <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>