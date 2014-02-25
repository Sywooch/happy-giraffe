<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 25/02/14
 * Time: 11:26
 * To change this template use File | Settings | File Templates.
 */

class PasswordRecoveryController extends HController
{
    public function actionSend()
    {
        $model = new PasswordRecoveryForm();

        $this->performAjaxValidation($model);

        if (isset($_POST['PasswordRecoveryForm'])) {
            $model->attributes = $_POST['PasswordRecoveryForm'];
            $success = $model->validate() && $model->send();
            echo CJSON::encode(compact('success'));
        }
    }

    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'passwordRecoveryForm')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}