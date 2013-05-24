<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $dp,
    'columns'=>array(
        'id',
        'entity',
        'entity_id',
        'user_id',
        'updated',
        'created',
        'note',
        array(
            'name' => 'title',
            'value' => '$data->relatedModel->title',
        ),
        array(
            'name' => 'tagsNames',
            'value' => '$data->tagsNames',
        ),
    ),
));