<h1>Категории интересов</h1>

 <?php echo CHtml::link('создать', array('InterestCategory/create')) ?><?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'interest-category-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'title',
		'css_class',
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
)); ?>
