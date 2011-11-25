<?php
$this->breadcrumbs=array(
	'Contest Users'=>array('index'),
	$model->user_id,
);

$this->menu=array(
	array('label'=>'List ContestUser', 'url'=>array('index')),
	array('label'=>'Create ContestUser', 'url'=>array('create')),
	array('label'=>'Update ContestUser', 'url'=>array('update', 'id'=>$model->user_id)),
	array('label'=>'Delete ContestUser', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->user_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ContestUser', 'url'=>array('admin')),
);
?>

<h1>View ContestUser #<?php echo $model->user_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'user_id',
		'user_user_id',
		'user_contest_id',
		'user_work_count',
	),
)); ?>
