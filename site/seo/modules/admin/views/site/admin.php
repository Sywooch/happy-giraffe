<h1>Manage Sites</h1>

 <?php echo CHtml::link('создать', array('/admin/site/create')) ?><?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'site-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		'url',
		'section',
		'type',
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
)); ?>
