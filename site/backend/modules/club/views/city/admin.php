<h1>Склонения городов</h1>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'geo-city-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		'name_from',
		'name_between',
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}'
		),
	),
));