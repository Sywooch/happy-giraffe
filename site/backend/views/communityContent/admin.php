<h1>Manage Community Contents</h1>

 <?php echo CHtml::link('создать', array('CommunityContent/create')) ?><?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'community-content-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		'author_id',
		'rubric_id',
        array(
            'name'=>'type_id',
            'value'=>'($data->type !== null)?$data->type->name:""',
        ),
        'removed',
		/*
		'preview',
		'meta_title',
		'meta_keywords',
		'meta_description',
		'by_happy_giraffe',
		'edited',
		'editor_id',
		*/
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
)); ?>
