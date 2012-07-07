<h1>Manage Test Results</h1>

 <?php echo CHtml::link('создать', array('TestResult/create')) ?><?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'test-result-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'test_id',
		'title',
		'image',
		'number',
		'priority',
		/*
		'points',
		'text',
		*/
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
)); ?>
