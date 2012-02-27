<?php
$this->breadcrumbs=array(
	'Community Contents'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List CommunityContent', 'url'=>array('index')),
	array('label'=>'Create CommunityContent', 'url'=>array('create')),
	array('label'=>'Update CommunityContent', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CommunityContent', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CommunityContent', 'url'=>array('admin')),
);
?>

<h1>View CommunityContent #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'created',
		'rating',
		'author_id',
		'rubric_id',
	),
)); ?>


<br /><h2> This CommunityComment belongs to this CommunityContent: </h2>
<ul><?php foreach($model->comments as $foreignobj) { 

				printf('<li>%s</li>', CHtml::link($foreignobj->text, array('communitycomment/view', 'id' => $foreignobj->id)));

				} ?></ul>