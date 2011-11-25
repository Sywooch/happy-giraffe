<?php
$this->breadcrumbs=array(
	'Vaccines'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Vaccine', 'url'=>array('index')),
	array('label'=>'Create Vaccine', 'url'=>array('create')),
	array('label'=>'Update Vaccine', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Vaccine', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Vaccine', 'url'=>array('admin')),
);
?>

<h1>View Vaccine #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
	),
)); ?>


