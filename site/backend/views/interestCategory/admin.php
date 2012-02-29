<h1>Manage Interest Categories</h1>

 <?php echo CHtml::link('создать', array('InterestCategory/create')) ?><?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'interest-category-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		'css_class',
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
)); ?>
