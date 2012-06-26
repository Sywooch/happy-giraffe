<h1>Manage Queries</h1>

 <?php echo CHtml::link('создать', array('Query/create')) ?><?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'query-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		array(
		    'name'=>'keyword_id',
		    'value'=>'$data->keyword_id." ".$data->keyword->name',
		),
		'visits',
		'parsing',
		'yandex_parsed',
		'google_parsed',
		'week',
		'year',
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
)); ?>
