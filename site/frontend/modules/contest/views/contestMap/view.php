<?php
$this->breadcrumbs=array(
	'Contest Maps'=>array('index'),
	$model->map_id,
);

$this->menu=array(
	array('label'=>'List ContestMap', 'url'=>array('index')),
	array('label'=>'Create ContestMap', 'url'=>array('create')),
	array('label'=>'Update ContestMap', 'url'=>array('update', 'id'=>$model->map_id)),
	array('label'=>'Delete ContestMap', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->map_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ContestMap', 'url'=>array('admin')),
);
?>

<h1>View ContestMap #<?php echo $model->map_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'map_id',
		'map_contest_id',
		'map_object',
		'map_object_id',
	),
)); ?>
