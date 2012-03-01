<h1>Manage Horoscopes</h1>

<?php echo CHtml::link('создать', array('horoscope/create')) ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'horoscope-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
		    'name'=>'zodiac',
		    'value'=>'$data->zodiacText()',
		),
		array(
		    'name'=>'date',
		    'value'=>'$data->dateText()',
		),
		'text',
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
)); ?>
