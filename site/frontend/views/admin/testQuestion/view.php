<?php
$this->breadcrumbs=array(
	'Test Questions'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List TestQuestion', 'url'=>array('index')),
	array('label'=>'Create TestQuestion', 'url'=>array('create')),
	array('label'=>'Update TestQuestion', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete TestQuestion', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TestQuestion', 'url'=>array('admin')),
);
?>

<h1>View TestQuestion #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'test_id',
		'name',
		'image',
		'number',
		'text',
	),
)); ?>
