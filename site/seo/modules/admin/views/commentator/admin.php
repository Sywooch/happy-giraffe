<h1>Manage Commentators</h1>

 <?php echo CHtml::link('создать', array('Commentator/create')) ?><?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'commentator-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'manager.name',
		'commentator_id',
		'commentatorName',
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
)); ?>
