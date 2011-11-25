<?php
$this->breadcrumbs=array(
	'Community Comments'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List CommunityComment', 'url'=>array('index')),
	array('label'=>'Create CommunityComment', 'url'=>array('create')),
	array('label'=>'Update CommunityComment', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CommunityComment', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CommunityComment', 'url'=>array('admin')),
);
?>

<h1>View CommunityComment #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'text',
		'author_id',
		'content_id',
	),
)); ?>


