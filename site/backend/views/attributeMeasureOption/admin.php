<h1>Manage Attribute Measure Options</h1>
<?php echo CHtml::link('Create', array('create')) ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'attribute-measure-option-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'measure.title',
		'title',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
