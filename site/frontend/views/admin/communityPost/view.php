<?php
$this->breadcrumbs=array(
	'Community Posts'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List CommunityPost', 'url'=>array('index')),
	array('label'=>'Create CommunityPost', 'url'=>array('create')),
	array('label'=>'Update CommunityPost', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CommunityPost', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CommunityPost', 'url'=>array('admin')),
);
?>

<h1>View CommunityPost #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'text',
		'source_type',
		'internet_link',
		'internet_favicon',
		'internet_title',
		'book_author',
		'book_name',
		'content_id',
	),
)); ?>


