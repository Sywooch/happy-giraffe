<h1>Manage Horoscope Compatibilities</h1>

 <?php echo CHtml::link('создать', array('/club/horoscopeCompatibility/create')) ?><?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'horoscope-compatibility-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
		    'name'=>'zodiac1',
		    'value'=>'$data->getZodiacText($data->zodiac1)',
		),
        array(
            'name'=>'zodiac2',
            'value'=>'$data->getZodiacText($data->zodiac2)',
        ),
		'text',
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
));