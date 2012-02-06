<h1>Manage Age Ranges</h1>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'age-range-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'range_id',
		'range_title',
		'range_order',
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
)); ?>
