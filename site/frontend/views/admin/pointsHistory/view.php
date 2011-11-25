<?php
$this->breadcrumbs=array(
	'Points Histories'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List PointsHistory', 'url'=>array('index')),
	array('label'=>'Create PointsHistory', 'url'=>array('create')),
	array('label'=>'Update PointsHistory', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete PointsHistory', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PointsHistory', 'url'=>array('admin')),
);
?>

<h1>View PointsHistory #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'note',
		'amount',
		'user_id',
	),
)); ?>


