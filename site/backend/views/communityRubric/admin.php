<h1>Manage Community Rubrics</h1>

 <?php echo CHtml::link('создать', array('CommunityRubric/create')) ?><?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'community-rubric-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'title',
		'community_id',
		'user_id',
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
)); ?>
