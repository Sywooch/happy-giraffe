<?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider'=>$dataProvider,
        'columns' => array(
            array(
                'value' => '$data->from_id == Yii::app()->user->id ? "→" : "←"',
            ),
            array(
                'name' => 'from_id',
                'value' => 'CHtml::encode($data->from->first_name) . " " . CHtml::encode($data->from->last_name)',
            ),
            array(
                'name' => 'to_id',
                'value' => 'CHtml::encode($data->to->first_name) . " " . CHtml::encode($data->to->last_name)',
            ),
            'text',
            array(
                'name' => 'status',
                'value' => '$data->statusLabel',
            ),
            array(
                'name' => 'read_status',
                'value' => '$data->read_status ? "Да" : "Нет"',
            ),
            'created',
            'updated',
            array(
                'class' => 'CButtonColumn',
                'buttons' => array(
                    'accept' => array(
                        'label' => 'Принять',
                        'visible' => '$data->status == "pending" && $data->to_id == Yii::app()->user->id',
                        'url' => 'Yii::app()->controller->createUrl("friendRequests/reply", array("request_id" => $data->id, "new_status" => "accepted"))',
                    ),
                    'decline' => array(
                        'label' => 'Отклонить',
                        'visible' => '$data->status == "pending" && $data->to_id == Yii::app()->user->id',
                        'url' => 'Yii::app()->controller->createUrl("friendRequests/reply", array("request_id" => $data->id, "new_status" => "declined"))',
                    ),
                ),
                'template' => '{accept} {decline}',
            ),
        ),
    ));
