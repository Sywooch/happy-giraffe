<h1>Manage Cook Recipe Tags</h1>

 <?php echo CHtml::link('создать', array('CookRecipeTag/create')) ?><?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'cook-recipe-tag-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'title',
		'text_title',
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}'
		),
	),
)); ?>
