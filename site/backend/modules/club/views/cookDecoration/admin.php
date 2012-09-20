<h1>Manage Cook Decorations</h1>

 <?php echo CHtml::link('создать', array('CookDecoration/create')) ?><?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'cook-decoration-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		array(
		    'name'=>'photo_id',
		    'value'=>'CHtml::image($data->photo->getPreviewUrl(70, 70))',
            'type'=>'raw'
		),
		'title',
        'description',
        array(
            'header' => 'Автор',
            'value' => 'CHtml::link($data->photo->author->fullName, $data->photo->author->url)',
            'type' => 'raw',
        ),
		'created',
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
)); ?>
