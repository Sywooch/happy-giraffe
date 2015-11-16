<?php

/**
 * @property RabbitMQ $rabbit.
 * Just sends a model instance to a RabbitMQ query.
 */
class RabbitMQBehavior extends CActiveRecordBehavior
{
    public function afterSave($event) {
        //\Yii::app()->rabbitMQ->send($this->getOwner());
    }
}