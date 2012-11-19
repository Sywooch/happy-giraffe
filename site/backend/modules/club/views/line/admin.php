<h1>Manage Lines</h1>

 <?php echo CHtml::link('создать', array('Line/create')) ?><?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'line-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		array(
		    'name'=>'type',
		    'value'=>'$data->getTextType()',
		),
		'image_id',
		'title',
		'date',
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
)); ?>
