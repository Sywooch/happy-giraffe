<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $dp,
    'columns' => array(
        'id',
        'title',
        array(
            'header' => 'Кол-во тем',
            'value' => '$data->contentsCount',
        ),
        array(
            'header' => 'Кол-во комментариев',
            'value' => '$data->commentsCount',
        ),
        array(
            'header' => 'Кол-во участников',
            'value' => '$data->usersCount',
        ),
    ),
));
