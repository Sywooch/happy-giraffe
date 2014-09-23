<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 23/09/14
 * Time: 16:31
 */

namespace site\frontend\components\api;


class CreateAction extends \CAction
{
    public $modelName;

    public function run()
    {
        /** @var \HActiveRecord $model */
        $model = new $this->modelName();
        if (isset($_POST['attributes'])) {
            $model->attributes = $_POST['attributes'];
            $this->controller->success = $model->save();
            $this->controller->data = $model->hasErrors() ? array(
                'errors' => $model->getErrors(),
            ) : array(
                'attributes' => new \CJavaScriptExpression(\HJSON::encode($model)),
            );
        }
    }
} 