<h1>Смс на День Свтого Валентина</h1>

 <?php echo CHtml::link('добавить', array('ValentineSms/create')) ?><?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'valentine-sms-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'title',
		'text',
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
));
