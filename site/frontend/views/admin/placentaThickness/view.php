<?php
$this->breadcrumbs=array(
	'Placenta Thicknesses'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List PlacentaThickness', 'url'=>array('index')),
	array('label'=>'Create PlacentaThickness', 'url'=>array('create')),
	array('label'=>'Update PlacentaThickness', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete PlacentaThickness', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PlacentaThickness', 'url'=>array('admin')),
);
?>

<h1>View PlacentaThickness #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'week',
		'min',
		'avg',
		'max',
	),
)); ?>
