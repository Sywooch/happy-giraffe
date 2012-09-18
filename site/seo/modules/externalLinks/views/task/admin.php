<h1>Manage Eltasks</h1>

 <?php echo CHtml::link('создать', array('create')) ?><?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'eltask-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'site_id',
		'type',
		'user_id',
		'created',
		'start_date',
		'closed',
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
)); ?>
