<h1>Управление мерами</h1>

 <?php echo CHtml::link('создать', array('cookUnit/create')) ?><?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'cook-unit-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'title',
		'title2',
		'title3',
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
)); ?>
