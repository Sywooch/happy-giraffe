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
            //'filter'=>CHtml::listData(Yii::app()->authManager->getRoles(), 'name', 'name')
            'filter'=>false
        ),
        array(
            'name'=>'assigns',
            'type'=>'html',
            'value'=>'$data->getAssigns()',
            'filter'=>false
        ),
		array(
		    'name'=>'last_active',
            'filter'=>false
		),
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}'
		),
	),
)); ?>
