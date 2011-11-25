<?php
$this->breadcrumbs=array(
	'Contest Winners'=>array('index'),
	$model->winner_id,
);

$this->menu=array(
	array('label'=>'List ContestWinner', 'url'=>array('index')),
	array('label'=>'Create ContestWinner', 'url'=>array('create')),
	array('label'=>'Update ContestWinner', 'url'=>array('update', 'id'=>$model->winner_id)),
	array('label'=>'Delete ContestWinner', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->winner_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ContestWinner', 'url'=>array('admin')),
);
?>

<h1>View ContestWinner #<?php echo $model->winner_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'winner_id',
		'winner_contest_id',
		'winner_place',
		'winner_prize_id',
		'winner_user_id',
		'winner_work_id',
	),
)); ?>
