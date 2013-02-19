<?php

$this->widget('zii.widgets.grid.CGridView', array(
    'enablePagination' => false,
    'summaryText' => '',
    'dataProvider' => new CActiveDataProvider ('CookIngredientSynonym', array(
        'criteria' => array(
            'condition' => 'ingredient_id = ' . $model->id,
            'order' => 'id'
        ),
        'pagination' => array(
            'pageSize' => 100
        )
    )),
    'columns' => array(
        'id',
        'title',
        array(
            'header' => 'Удалить',
            'type' => 'raw',
            'value' => 'CHtml::link ( CHtml::encode ( "удалить" ),  array ( "cookIngredients/deleteSynonym", "id" => $data->id ), array("onclick"=>"Nutritionals.deleteChild(event,\'synonyms\');") )'
        )

    ),
    'enablePagination' => false,
    'ajaxUpdate' => 'false'
));