<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 8/31/13
 * Time: 12:38 PM
 * To change this template use File | Settings | File Templates.
 */

class MeController extends HController
{
    public function actionUpdateAttribute()
    {
        $attribute = Yii::app()->request->getPost('attribute');
        $value = Yii::app()->request->getPost('value');
        $user = Yii::app()->user->model;
        $user->$attribute = $value;
        $success = $user->save(true, array($attribute));
        $response = compact('success');
        echo CJSON::encode($response);
    }
}