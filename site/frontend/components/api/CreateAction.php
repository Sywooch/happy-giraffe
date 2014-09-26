<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 23/09/14
 * Time: 16:31
 */

namespace site\frontend\components\api;


class CreateAction extends ApiAction
{
    public function run(array $attributes)
    {
        if (! \Yii::app()->user->checkAccess($this->checkAccess)) {
            throw new \CHttpException(403, 'Недостаточно прав');
        }

        /** @var \HActiveRecord $model */
        $model = new $this->modelName();
        $model->attributes = $attributes;
        $this->controller->success = $model->save();
        $this->controller->data = $model->hasErrors() ? array(
            'errors' => $model->getErrors(),
        ) : $model;
    }
} 