<h1>Manage Community Statuses</h1>

 <?php echo CHtml::link('создать', array('CommunityStatus/create')) ?><?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'community-status-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'status_id',
		'content_id',
		'text',
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
)); ?>
