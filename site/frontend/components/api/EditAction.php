<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 23/09/14
 * Time: 16:31
 */

namespace site\frontend\components\api;


class EditAction extends ApiAction
{
    public $modelName;

    public function run(array $attributes, $id)
    {
        /** @var \HActiveRecord $model */
        $model = $this->controller->getModel($this->modelName, $id, $this->checkAccess);
        $model->attributes = $attributes;
        $this->controller->success = $model->save();
        $this->controller->data = $model->hasErrors() ? array(
            'errors' => $model->getErrors(),
        ) : $model;
    }
} 