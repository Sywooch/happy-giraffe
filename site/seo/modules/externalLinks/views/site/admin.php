<h1>Manage Elsites</h1>

 <?php echo CHtml::link('создать', array('create')) ?><?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'elsite-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'url',
		'type',
		'status',
		'created',
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
)); ?>
