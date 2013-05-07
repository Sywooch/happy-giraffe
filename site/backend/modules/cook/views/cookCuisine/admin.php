<h1>Manage Cook Cuisines</h1>

 <?php echo CHtml::link('создать', array('CookCuisine/create')) ?><?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'cook-cuisine-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'title',
		'country.name',
        array(
            'value'=>'isset($data->country)?$data->country->getFlag():""',
            'type'=>'raw'
        ),
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
)); ?>
