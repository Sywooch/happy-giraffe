<h1>Новые маршруты</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'route-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'id',
        array(
            'name' => 'city_from_id',
            'value' => '$data->cityFrom->name',
        ),
        array(
            'name' => 'city_to_id',
            'value' => '$data->cityTo->name',
        ),
        'distance',
        'wordstat_value',
        array(
            'name' => 'status',
            'value' => '$data->getTextStatus()',
        ),
        array(
            'name' => 'checked',
            'type' => 'raw',
            'value' => '$data->getRouteLink()',
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{delete}'
        ),
    ),
));