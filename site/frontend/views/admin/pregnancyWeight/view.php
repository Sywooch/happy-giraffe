<?php
$this->breadcrumbs=array(
	'Pregnancy Weights'=>array('index'),
	$model->week,
);

$this->menu=array(
	array('label'=>'List PregnancyWeight', 'url'=>array('index')),
	array('label'=>'Create PregnancyWeight', 'url'=>array('create')),
	array('label'=>'Update PregnancyWeight', 'url'=>array('update', 'id'=>$model->week)),
	array('label'=>'Delete PregnancyWeight', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->week),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PregnancyWeight', 'url'=>array('admin')),
);
?>

<h1>View PregnancyWeight #<?php echo $model->week; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'week',
		'w1',
		'w2',
		'w3',
	),
)); ?>
