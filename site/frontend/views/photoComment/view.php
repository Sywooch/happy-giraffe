<?php
$this->breadcrumbs=array(
	'Photo Comments'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List PhotoComment', 'url'=>array('index')),
	array('label'=>'Create PhotoComment', 'url'=>array('create')),
	array('label'=>'Update PhotoComment', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete PhotoComment', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PhotoComment', 'url'=>array('admin')),
);
?>

<h1>View PhotoComment #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'content',
		'status',
		'create_time',
		'update_time',
		'author_id',
		'post_id',
	),
)); ?>
