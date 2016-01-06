<?php

use site\frontend\modules\posts\models\Content;
use site\common\models\CommunityContent;

/**
 * @property RabbitMQ $rabbit.
 * Just sends a model instance to a RabbitMQ query.
 */
class RabbitMQBehavior extends CActiveRecordBehavior
{
    public function afterSave($event) {
        parent::afterSave($event);

        \Yii::log(var_export(\Yii::app()->params['is_api_request'], true), 'info', 'rabbit.behavior');
        if (\Yii::app()->params['is_api_request']) {
            //\Yii::app()->params['is_api_request'] = false;
            return;
        }

        if ($this->getOwner() instanceof Content) {
            $data = $this->toArray($this->getOwner());

            $originClass = Content::$entityAliases[$this->getOwner()->originEntity];
            $origin = call_user_func(array($originClass, 'model'))->findByPk($this->getOwner()->originEntityId);
            $rubric_id = $origin->rubric_id;

            $data['rubric_id'] = $rubric_id;

            unset($data['labels']);

            \Yii::app()->rabbit->send(json_encode($data));
        } else {
            \Yii::app()->rabbit->send(json_encode($this->toArray($this->getOwner())));
        }
    }

    private function toArray($model) {
        $data = $model->getAttributes();
        $data['is_new_record'] = $model->getIsNewRecord();
        $data['table_name'] = $model->tableName();

        return $data;
    }
}