<?php
$this->breadcrumbs=array(
	'Names'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Name', 'url'=>array('index')),
	array('label'=>'Create Name', 'url'=>array('create')),
	array('label'=>'Update Name', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Name', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Name', 'url'=>array('admin')),
);
?>

<h1>View Name #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'gender',
		'translate',
		'origin',
		'nameGroup.name',
		'options',
		'sweet',
		'middle_names',
		'likes',
	),
)); ?>


<br /><h2> This NameFamous belongs to this Name: </h2>
<ul><?php foreach($model->nameFamouses as $foreignobj) { 

				printf('<li>%s</li>', CHtml::link($foreignobj->middle_name, array('namefamous/view', 'id' => $foreignobj->id)));

				} ?></ul><br /><h2> This NameSaintDate belongs to this Name: </h2>
<ul><?php foreach($model->nameSaintDates as $foreignobj) { 

				printf('<li>%s</li>', CHtml::link($foreignobj->day, array('namesaintdate/view', 'id' => $foreignobj->id)));

				} ?></ul><br /><h2> This User belongs to this Name: </h2>
<ul><?php foreach($model->users as $foreignobj) { 

				printf('<li>%s</li>', CHtml::link($foreignobj->external_id, array('user/view', 'id' => $foreignobj->id)));

				} ?></ul>