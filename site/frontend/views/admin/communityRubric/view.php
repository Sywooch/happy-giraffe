<?php
$this->breadcrumbs=array(
	'Community Rubrics'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List CommunityRubric', 'url'=>array('index')),
	array('label'=>'Create CommunityRubric', 'url'=>array('create')),
	array('label'=>'Update CommunityRubric', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CommunityRubric', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CommunityRubric', 'url'=>array('admin')),
);
?>

<h1>View CommunityRubric #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'community_id',
		'type_id',
	),
)); ?>


<br /><h2> This CommunityContent belongs to this CommunityRubric: </h2>
<ul><?php foreach($model->contents as $foreignobj) { 

				printf('<li>%s</li>', CHtml::link($foreignobj->name, array('communitycontent/view', 'id' => $foreignobj->id)));

				} ?></ul>