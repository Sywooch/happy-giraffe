<h1>Интересы</h1>

 <?php echo CHtml::link('создать', array('interest/create')) ?><?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'interest-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
        'id',
		'title',
		'category.title',
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
)); ?>
