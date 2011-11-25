<?php
$this->breadcrumbs=array(
	'Community Videos'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List CommunityVideo', 'url'=>array('index')),
	array('label'=>'Create CommunityVideo', 'url'=>array('create')),
	array('label'=>'Update CommunityVideo', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CommunityVideo', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CommunityVideo', 'url'=>array('admin')),
);
?>

<h1>View CommunityVideo #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'link',
		'text',
		'content_id',
	),
)); ?>


