<?php
$this->breadcrumbs=array(
	'Name Famouses'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List NameFamous', 'url'=>array('index')),
	array('label'=>'Create NameFamous', 'url'=>array('create')),
	array('label'=>'Update NameFamous', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete NameFamous', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage NameFamous', 'url'=>array('admin')),
);
?>

<h1>View NameFamous #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name_id',
		'middle_name',
		'last_name',
		'description',
		'photo',
	),
)); ?>
