<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 23/09/14
 * Time: 16:31
 */

namespace site\frontend\components\api;


class EditAction extends \CAction
{
    public $modelName;

    public function run(array $attributes, $id)
    {
        /** @var \HActiveRecord $model */
        $model = \HActiveRecord::model($this->modelName)->findByPk($id);
        if ($model === null) {
            throw new \CHttpException(404, 'Модель не найдена');
        }
        $model->attributes = $attributes;
        $this->controller->success = $model->save();
        $this->controller->data = $model->hasErrors() ? array(
            'errors' => $model->getErrors(),
        ) : $model;
    }
} 