<?php
$this->breadcrumbs=array(
	'Name Famouses'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List NameFamous', 'url'=>array('index')),
	array('label'=>'Create NameFamous', 'url'=>array('create')),
);
?>

<h1>Manage Name Famouses</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'name-famous-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
		    'name'=>'name_id',
		    'value'=>'$data->name->name',
		),
		'last_name',
		'description',
		array(
		    'name'=>'photo',
		    'value'=>'$data->GetAdminPhoto()',
		),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
