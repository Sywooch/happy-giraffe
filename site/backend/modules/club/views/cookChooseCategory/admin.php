<h1>Администрирование категорий "Как выбрать"</h1>

 <?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'cook-choose-category-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
        array(
            'name' => 'title',
            'value' => 'CHtml::link ( CHtml::encode ( $data->title ),  array ( "update", "id" => $data->id ) )',
            'type'=>'raw'
        ),
        array(
            'name' => 'photo_id',
            'value' => '$data->getImage()',
            'type' => 'raw'
        ),
		array(
			'class'=>'CButtonColumn',
			'template' => '{update}'
		),
	),
)); ?>
