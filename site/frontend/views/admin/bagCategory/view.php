<?php
$this->breadcrumbs=array(
	'Bag Categories'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List BagCategory', 'url'=>array('index')),
	array('label'=>'Create BagCategory', 'url'=>array('create')),
	array('label'=>'Update BagCategory', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete BagCategory', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage BagCategory', 'url'=>array('admin')),
);
?>

<h1>View BagCategory #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
	),
)); ?>
