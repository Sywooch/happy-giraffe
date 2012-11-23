<h1>Manage siteGroups</h1>

 <?php echo CHtml::link('создать', array('siteGroup/create'));

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'siteGroup-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'site.name',
		'group.name',
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
)); ?>
