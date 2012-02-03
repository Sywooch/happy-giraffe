<h1>Manage Attribute Measures</h1>
<?php echo CHtml::link('Create', array('create')) ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'attribute-measure-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'title',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
