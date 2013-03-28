<h1>Цены на топливо</h1>

 <?php echo CHtml::link('создать', array('FuelCost/create')) ?><?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'fuel-cost-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'currency_name',
		'cost',
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}'
		),
	),
)); ?>
