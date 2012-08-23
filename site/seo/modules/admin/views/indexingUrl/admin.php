<h1>Manage Indexing Urls</h1>

 <?php echo CHtml::link('создать', array('IndexingUrl/create')) ?><?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'indexing-url-grid',
	'dataProvider'=>$model->search(),
    'ajaxUpdate'=>false,
	'filter'=>$model,
	'columns'=>array(
		'id',
		'url',
		'active',
		'type',
		'old',
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
)); ?>
