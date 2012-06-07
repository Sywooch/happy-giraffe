<?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider' => $dp,
        'columns' => array(
            'name',
            array(
                'value' => 'CHtml::link("Было", str_replace("dev.happy-giraffe.ru", "www.happy-giraffe.ru", $data->url))',
                'type' => 'html',
            ),
            array(
                'value' => 'CHtml::link("Стало", $data->url)',
                'type' => 'html',
            ),
        ),
    ));
