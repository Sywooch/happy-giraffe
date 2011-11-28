<?php
$this->breadcrumbs=array(
	'Bag Items'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List BagItem', 'url'=>array('index')),
	array('label'=>'Create BagItem', 'url'=>array('create')),
	array('label'=>'View BagItem', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage BagItem', 'url'=>array('admin')),
);
?>

<h1>Update BagItem <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>