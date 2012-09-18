<h1>Manage Ellinks</h1>

 <?php echo CHtml::link('создать', array('create')) ?><?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'ellink-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'site_id',
		'url',
		'our_link',
		'author_id',
		'created',
		/*
		'check_link_time',
		'link_type',
		'link_cost',
		'system_id',
		*/
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
)); ?>
