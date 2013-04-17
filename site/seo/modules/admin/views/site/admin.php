<h1>Сайты</h1>

<?php echo CHtml::link('создать', array('/admin/site/create'));

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'site-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		'url',
		'password',
		'section',
		array(
		    'name'=>'type',
		    'value'=>'$data->GetTypeName()',
		),
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
));
