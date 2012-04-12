<h1>Manage Contest Works</h1>

 <?php echo CHtml::link('создать', array('ContestWork/create')) ?><?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'contest-work-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'contest_id',
		'user_id',
		'title',
		'created',
		'rate',
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
)); ?>
