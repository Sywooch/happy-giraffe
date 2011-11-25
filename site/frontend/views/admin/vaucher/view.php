<?php
$this->breadcrumbs=array(
	'Vauchers'=>array('index'),
	$model->vaucher_id,
);

$this->menu=array(
	array('label'=>'List Vaucher', 'url'=>array('index')),
	array('label'=>'Create Vaucher', 'url'=>array('create')),
	array('label'=>'Update Vaucher', 'url'=>array('update', 'id'=>$model->vaucher_id)),
	array('label'=>'Delete Vaucher', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->vaucher_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Vaucher', 'url'=>array('admin')),
);
?>

<h1>View Vaucher #<?php echo $model->vaucher_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'vaucher_id',
		'vaucher_code',
		'vaucher_discount',
		'vaucher_from_time',
		'vaucher_till_time',
		'vaucher_text',
		'vaucher_time:datetime',
	),
)); ?>
