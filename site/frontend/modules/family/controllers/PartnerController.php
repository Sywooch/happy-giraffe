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
    public $partner;

    public function init()
    {
        $this->partner = Yii::app()->user->model->partner;
    }

    public function actionUpdateAttribute()
    {
        $attribute = Yii::app()->request->getPost('attribute');
        $value = Yii::app()->request->getPost('value');
        $this->partner->$attribute = $value;
        $success = $this->partner->save(true, array($attribute));
        $response = compact('success');
        echo CJSON::encode($response);
    }

    public function actionRemove()
    {
        $user = Yii::app()->user->model;
        $user->relationship_status = null;
        $success = $user->save(true, array('relationship_status') && $this->partner->delete();
        $response = compact('success');
        echo CJSON::encode($response);
    }
}