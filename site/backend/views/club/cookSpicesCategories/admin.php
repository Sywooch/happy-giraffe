<h1>Категории специй</h1>

<?php

//echo CHtml::link('создать', array('create'));

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'cook-spices-categories-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        //'id',
        array(
            'name' => 'title',
            'value' => 'CHtml::link ( CHtml::encode ( $data->title ),  array ( "update", "id" => $data->id ) )',
            'type'=>'raw'
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{update}{delete}'
        ),
    ),
));
?>
