<?php
$this->breadcrumbs=array(
	'Contest Work Comments'=>array('index'),
	$model->comment_id,
);

$this->menu=array(
	array('label'=>'List ContestWorkComment', 'url'=>array('index')),
	array('label'=>'Create ContestWorkComment', 'url'=>array('create')),
	array('label'=>'Update ContestWorkComment', 'url'=>array('update', 'id'=>$model->comment_id)),
	array('label'=>'Delete ContestWorkComment', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->comment_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ContestWorkComment', 'url'=>array('admin')),
);
?>

<h1>View ContestWorkComment #<?php echo $model->comment_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'comment_id',
		'comment_user_id',
		'comment_work_id',
		'comment_text',
		'comment_status',
		'comment_time',
		'comment_answer',
	),
)); ?>
