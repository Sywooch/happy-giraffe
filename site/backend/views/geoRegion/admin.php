<h1>Регионы</h1>

 <?php echo CHtml::link('создать', array('GeoRegion/create')) ?><?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'geo-region-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'country.name',
		'name',
		'type',
		'center.name',
		'position',
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
)); ?>
