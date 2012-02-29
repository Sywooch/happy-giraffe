<?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider'=>$dataProvider,
        'columns' => array(
            array(
                'value' => '$data->from_id == Yii::app()->user->id ? \'→\' : \'←\'',
            ),
            array(
                'name' => 'from_id',
                'value' => '$data->from->first_name . \' \' . $data->from->last_name',
            ),
            array(
                'name' => 'to_id',
                'value' => '$data->to->first_name . \' \' . $data->to->last_name',
            ),
            'text',
            array(
                'name' => 'status',
                'value' => '$data->statusLabel',
            ),
            array(
                'name' => 'read_status',
                'value' => '$data->read_status ? \'Да\' : \'Нет\'',
            ),
            'created',
            array(
                'class' => 'CButtonColumn',
                'buttons' => array(
                    'accept' => array(
                        'label' => 'Принять',
                        'visible' => '$data->status == \'pending\' && $data->to_id == Yii::app()->user->id',
                        'click' => 'funtion() {alert(\'123\');}'
                    ),
                    'decline' => array(
                        'label' => 'Отклонить',
                        'visible' => '$data->status == \'pending\' && $data->to_id == Yii::app()->user->id',
                    ),
                ),
                'template' => '{accept} {decline}',
            ),
        ),
    ));
