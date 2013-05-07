<h1>Manage User Statuses</h1>

 <?php echo CHtml::link('создать', array('UserStatus/create')) ?><?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-status-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'text',
		'user_id',
		'created',
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
)); ?>
