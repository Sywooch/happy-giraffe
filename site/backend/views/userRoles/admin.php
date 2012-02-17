<h1>Роли пользователей</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'email',
		'first_name',
		'last_name',
		array(
		    'name'=>'role',
		    'value'=>'$data->getRole()',
		),
//		'last_active',
//		'register_date',
//		'login_date',
//		'last_ip',
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
)); ?>
