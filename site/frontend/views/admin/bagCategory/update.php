<?php
$this->breadcrumbs=array(
	'Bag Categories'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List BagCategory', 'url'=>array('index')),
	array('label'=>'Create BagCategory', 'url'=>array('create')),
	array('label'=>'View BagCategory', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage BagCategory', 'url'=>array('admin')),
);
?>

<h1>Update BagCategory <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>