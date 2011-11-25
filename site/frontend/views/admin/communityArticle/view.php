<?php
$this->breadcrumbs=array(
	'Community Articles'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List CommunityArticle', 'url'=>array('index')),
	array('label'=>'Create CommunityArticle', 'url'=>array('create')),
	array('label'=>'Update CommunityArticle', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CommunityArticle', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CommunityArticle', 'url'=>array('admin')),
);
?>

<h1>View CommunityArticle #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'text',
		'source_type',
		'internet_link',
		'book_author',
		'book_name',
		'content_id',
	),
)); ?>


