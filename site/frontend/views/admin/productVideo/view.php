<?php
$this->breadcrumbs=array(
	'Product Videos'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List ProductVideo', 'url'=>array('index')),
	array('label'=>'Create ProductVideo', 'url'=>array('create')),
	array('label'=>'Update ProductVideo', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ProductVideo', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ProductVideo', 'url'=>array('admin')),
);
?>

<h1>View ProductVideo #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'code',
		'title',
		'description',
		'preview',
		'url',
		'product_id',
	),
)); ?>
