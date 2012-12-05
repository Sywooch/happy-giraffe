<h1>Manage Traffic Sections</h1>

 <?php echo CHtml::link('создать', array('TrafficSection/create')) ?><?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'traffic-section-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'url',
		'title',
		'parent_id',
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
)); ?>
