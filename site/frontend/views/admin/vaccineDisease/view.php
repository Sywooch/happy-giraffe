<?php
$this->breadcrumbs=array(
	'Vaccine Diseases'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List VaccineDisease', 'url'=>array('index')),
	array('label'=>'Create VaccineDisease', 'url'=>array('create')),
	array('label'=>'Update VaccineDisease', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete VaccineDisease', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage VaccineDisease', 'url'=>array('admin')),
);
?>

<h1>View VaccineDisease #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'name_genitive',
	),
)); ?>


