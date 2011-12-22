<?php
$this->breadcrumbs=array(
	'Name Groups'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List NameGroup', 'url'=>array('index')),
	array('label'=>'Create NameGroup', 'url'=>array('create')),
	array('label'=>'Update NameGroup', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete NameGroup', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage NameGroup', 'url'=>array('admin')),
);
?>

<h1>View NameGroup #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
	),
)); ?>


<br /><h2> This Name belongs to this NameGroup: </h2>
<ul><?php foreach($model->names as $foreignobj) { 

				printf('<li>%s</li>', CHtml::link($foreignobj->name, array('name/view', 'id' => $foreignobj->id)));

				} ?></ul>