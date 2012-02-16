<h1>Manage Auth Items</h1>
<?php echo CHtml::link('создать', array('operationGroups/create')) ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'auth-item-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'name',
		'description',
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
)); ?>
