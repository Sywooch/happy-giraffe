<h1>Роли</h1>
<?php echo CHtml::link('создать', array('roles/create')) ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'auth-item-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'name',
		'description',
        array(
            'name'=>'children',
            'value'=>'$data->getChildrenElements()',
        ),
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
)); ?>
