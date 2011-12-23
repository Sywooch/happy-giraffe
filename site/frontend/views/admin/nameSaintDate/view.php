<?php
$this->breadcrumbs=array(
	'Name Saint Dates'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List NameSaintDate', 'url'=>array('index')),
	array('label'=>'Create NameSaintDate', 'url'=>array('create')),
	array('label'=>'Update NameSaintDate', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete NameSaintDate', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage NameSaintDate', 'url'=>array('admin')),
);
?>

<h1>View NameSaintDate #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name.name',
		'day',
		'month',
	),
)); ?>


