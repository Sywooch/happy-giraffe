<?php
/**
 * Class PasswordRecoveryController
 * Реализует функционал напоминания пароля
 */

class PasswordRecoveryController extends HController
{
    /**
     * Отправка нового пароля
     */
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

    /**
     * Ajax-валидация
     * @param $model
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'passwordRecoveryForm')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}