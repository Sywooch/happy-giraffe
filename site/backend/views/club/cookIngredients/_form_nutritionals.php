<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'enablePagination' => false,
    'summaryText' => '',
    'dataProvider' => new CActiveDataProvider ('CookIngredientsNutritionals', array(
        'criteria' => array(
            'condition' => 'ingredient_id = ' . $model->id,
            'order' => 'id'
        ),
        'pagination' => array(
            'pageSize' => 100
        )
    )),
    'columns' => array(
        array(
            'header' => 'Составляющая',
            'value' => '$data->nutritional->title'
        ),
        array(
            'header' => 'значение',
            'value' => '$data->value'
        ),

        array(
            'header' => 'Удалить',
            'type' => 'raw',
            'value' => 'CHtml::link ( CHtml::encode ( "удалить" ),  array ( "club/cookIngredients/ulinkNutritional", "id" => $data->id ) )'
        )

    ),
    'enablePagination' => false,
    'ajaxUpdate' => 'false'
));