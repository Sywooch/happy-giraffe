<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 17/09/14
 * Time: 15:24
 */

namespace site\frontend\components\actions;


class DeleteAction extends \CAction
{
    public $modelClass;

    public function run()
    {
        $id = \Yii::app()->request->getPost('id');
        $model = \CActiveRecord::model($this->modelClass)->findByPk($id);
        $success = $model->delete();
        echo \CJSON::encode(compact('success'));
    }
} 