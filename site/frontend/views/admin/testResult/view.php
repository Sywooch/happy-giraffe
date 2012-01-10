<?php
$this->breadcrumbs=array(
	'Test Results'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List TestResult', 'url'=>array('index')),
	array('label'=>'Create TestResult', 'url'=>array('create')),
	array('label'=>'Update TestResult', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete TestResult', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TestResult', 'url'=>array('admin')),
);
?>

<h1>View TestResult #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'test_id',
		'name',
		'image',
		'number',
		'priority',
		'text',
	),
)); ?>
