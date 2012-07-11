<h1>Специи</h1>

 <?php echo CHtml::link('создать', array('create')) ?><?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'cook-spices-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		//'ingredient_id',
        array(
            'value' => '$data->ingredient->title',
            'header' => 'Ингредиент'
        ),
        array(
            'name' => 'title',
            'value' => 'CHtml::link ( CHtml::encode ( $data->title ),  array ( "update", "id" => $data->id ) )',
            'type'=>'raw'
        ),
        'title_ablative',
        array(
            'name' => 'cats',
            'value'=> '$data->getCategoriesText()'
        ),
        array(
            'name'=>'photo_id',
            'value'=>'$data->getImage()',
            'type'=>'raw'
        ),
        'slug',
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}{delete}'
		),
	),
)); ?>
