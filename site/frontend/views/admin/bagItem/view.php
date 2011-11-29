<?php
$this->breadcrumbs=array(
	'Bag Items'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List BagItem', 'url'=>array('index')),
	array('label'=>'Create BagItem', 'url'=>array('create')),
	array('label'=>'Update BagItem', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete BagItem', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage BagItem', 'url'=>array('admin')),
);
?>

<h1>View BagItem #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'description',
		'approved',
		'for',
		'category_id',
	),
)); ?>
