<h1>Manage Pages</h1>

 <?php echo CHtml::link('создать', array('/admin/Page/create')) ?><?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'page-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'entity',
		'entity_id',
		'url',
		'keyword_group_id',
		'number',
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
)); ?>
