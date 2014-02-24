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
        $model = new LoginForm();

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'loginForm')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST['LoginForm']))
        {
            $model->attributes = $_POST['LoginForm'];
            if ($model->validate() && $model->login())
                $this->redirect(Yii::app()->user->returnUrl);
        }
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