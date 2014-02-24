<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 24/02/14
 * Time: 17:02
 * To change this template use File | Settings | File Templates.
 */

class LoginController extends HController
{
    public function actionDefault()
    {
        $model = new User('login');
        $model->attributes = $_POST['User'];
        $this->performAjaxValidation($model);
    }

    public function actionSocial()
    {

    }

    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax']==='loginForm')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}