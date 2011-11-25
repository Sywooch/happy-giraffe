<?php
$this->breadcrumbs=array(
	'Contest Prizes'=>array('index'),
	$model->prize_id,
);

$this->menu=array(
	array('label'=>'List ContestPrize', 'url'=>array('index')),
	array('label'=>'Create ContestPrize', 'url'=>array('create')),
	array('label'=>'Update ContestPrize', 'url'=>array('update', 'id'=>$model->prize_id)),
	array('label'=>'Delete ContestPrize', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->prize_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ContestPrize', 'url'=>array('admin')),
);
?>

<h1>View ContestPrize #<?php echo $model->prize_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'prize_id',
		'prize_contest_id',
		'prize_place',
		'prize_item_id',
		'prize_text',
	),
)); ?>
