<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 8/29/13
 * Time: 11:57 AM
 * To change this template use File | Settings | File Templates.
 */

class PartnerController extends HController
{
    public function actionUpdateAttribute()
    {
        $attribute = Yii::app()->request->getPost('attribute');
        $value = Yii::app()->request->getPost('value');
        $partner = Yii::app()->user->model->partner;
        $partner->$attribute = $value;
        $success = $partner->save(true, array($attribute));
        $response = compact('success');
        echo CJSON::encode($response);
    }
}