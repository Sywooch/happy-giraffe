<h1>Manage Li Sites</h1>

 <?php echo CHtml::link('создать', array('LiSite/create')) ?><?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'li-site-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'url',
		'site_url',
		'visits',
		'password',
		'public',
		/*
		'active',
		*/
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
)); ?>
