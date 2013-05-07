<h1>Роли пользователей</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'ajaxUpdate'=>false,
	'columns'=>array(
		'id',
		'email',
		'first_name',
		'last_name',
        array(
            'name'=>'role',
            'type'=>'html',
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
            'name'=>'group',
            'type'=>'html',
            'value'=>'UserGroup::getName($data->group)',
            'filter'=>false
        ),
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}'
		),
	),
)); ?>
