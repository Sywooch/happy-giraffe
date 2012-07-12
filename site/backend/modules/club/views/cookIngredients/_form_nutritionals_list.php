<?php

$this->widget('zii.widgets.grid.CGridView', array(
    'enablePagination' => false,
    'summaryText' => '',
    'dataProvider' => new CActiveDataProvider ('CookIngredientNutritional', array(
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
            'header' => 'Характеристика',
            'value' => '$data->nutritional->title'
        ),
        array(
            'header' => 'значение',
            'value' => '$data->value'
        ),

        array(
            'header' => 'Удалить',
            'type' => 'raw',
            'value' => 'CHtml::link ( CHtml::encode ( "удалить" ),  array ( "cookIngredients/unlinkNutritional", "id" => $data->id ), array("onclick"=>"Nutritionals.deleteChild(event,\'nutritionals\');") )'
        )

    ),
    'enablePagination' => false,
    'ajaxUpdate' => 'false'
));