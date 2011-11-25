<?php
$this->breadcrumbs=array(
	'Contests'=>array('admin'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Contest', 'url'=>array('index')),
	array('label'=>'Create Contest', 'url'=>array('create')),
);
?>

<h1>Manage Contests</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'contest-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'contest_id',
		'contest_title',
//		'contest_text',
//		'contest_image',
		'contest_from_time',
		'contest_till_time',
		array(
			'name'=>'contest_status',
			'value'=>'$data->statuses->statusText',
			'filter'=>$model->statuses->statuses,
		),
		/*
		'contest_time',
		'contest_user_id',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
