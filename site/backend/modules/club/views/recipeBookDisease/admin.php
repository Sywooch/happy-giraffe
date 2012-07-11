<h1>Болезни</h1>

 <?php echo CHtml::link('создать', array('RecipeBookDisease/create')) ?><?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'recipe-book-disease-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'title',
		array(
		    'name'=>'category_id',
		    'value'=>'$data->category->title',
		),
		'reasons_name',
        'symptoms_name',
        'diagnosis_name',
        'treatment_name',
        'prophylaxis_name',
        array(
            'name' => 'photo_id',
            'value' => '$data->getAdminImage()',
            'type' => 'raw'
        ),
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
));
