<?php

class BController extends CController
{
    public $section = 'shop';

    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'users' => array('@'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function beforeAction($action)
    {
        if (isset($this->authItem) && !Yii::app()->user->checkAccess($this->authItem))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        return true;
    }

    public function loadModel($id)
    {
        $model = CActiveRecord::model($this->_class)->findByPk($id);

        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function performAjaxValidation($model)
    {
        if (Yii::app()->request->isAjaxRequest && isset($_POST['ajax'])) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}