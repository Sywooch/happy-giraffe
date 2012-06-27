<h1>Manage Recipe Book Disease Categories</h1>

 <?php echo CHtml::link('создать', array('RecipeBookDiseaseCategory/create')) ?><?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'recipe-book-disease-category-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'title',
		'slug',
		'title_all',
        array(
            'name' => 'photo_id',
            'value' => '$data->getImage()',
            'type' => 'raw'
        ),
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
)); ?>
