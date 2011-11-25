<?php
$this->breadcrumbs=array(
	'Community Content Types'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List CommunityContentType', 'url'=>array('index')),
	array('label'=>'Create CommunityContentType', 'url'=>array('create')),
	array('label'=>'Update CommunityContentType', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CommunityContentType', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CommunityContentType', 'url'=>array('admin')),
);
?>

<h1>View CommunityContentType #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
	),
)); ?>


<br /><h2> This CommunityRubric belongs to this CommunityContentType: </h2>
<ul><?php foreach($model->rubrics as $foreignobj) { 

				printf('<li>%s</li>', CHtml::link($foreignobj->name, array('communityrubric/view', 'id' => $foreignobj->id)));

				} ?></ul>