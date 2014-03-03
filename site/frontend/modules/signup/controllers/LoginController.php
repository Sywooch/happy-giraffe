<?php
/**
 * Class LoginController
 * Реализует фунционал аутентификации пользователя на сайте
 */

class LoginController extends HController
{
    public function actions()
    {
        return array(
            'social' => array(
                'class' => 'signup.components.SignupSocialAction',
                'fromLogin' => true,
            ),
        );
    }

    /**
     * Стандартный сценарий авторизации - по паролю
     */
    public function actionDefault()
    {
        $model = new LoginForm();

        $this->performAjaxValidation($model);

        if (isset($_POST['LoginForm']))
        {
            $model->attributes = $_POST['LoginForm'];
            if ($model->validate() && $model->login())
                $this->redirect(Yii::app()->user->returnUrl);
        }
    }

    /**
     * Ajax-валидация
     * @param $model
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'loginForm')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}