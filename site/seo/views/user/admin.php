<h1>Manage Users</h1>

 <?php echo CHtml::link('создать', array('User/create')) ?><?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'email',
		'password',
		'name',
		'owner_id',
        'role',
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}'
		),
	),
)); ?>
