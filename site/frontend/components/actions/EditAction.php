<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 17/09/14
 * Time: 15:22
 */

namespace site\frontend\components\actions;


class EditAction extends \CAction
{
    public $modelClass;

    public function run()
    {
        $id = \Yii::app()->request->getPost('id');
        $model = \CActiveRecord::model($this->modelClass)->findByPk($id);
        $model->attributes = $_POST[\CHtml::modelName($model)];
        $success = $model->save();
        echo \CJSON::encode(compact('success'));
    }
} 