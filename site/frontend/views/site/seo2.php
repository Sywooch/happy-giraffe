<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $dp,
    'columns' => array(
        array(
            'name' => 'Ссылка',
            'type' => 'raw',
            'value' => 'CHtml::link(\'http://www.happy-giraffe.ru\' . $data->url, \'http://www.happy-giraffe.ru\' . $data->url)',
        ),
        array(
            'name' => 'google',
            'header' => 'Гугл',
            'type' => 'raw',
            'value' => 'CHtml::encode($data->google)',
        ),
        array(
            'name' => 'yande',
            'header' => 'Яндекс',
            'type' => 'raw',
            'value' => 'CHtml::encode($data->yandex)',
        ),
    ),
));
?>
