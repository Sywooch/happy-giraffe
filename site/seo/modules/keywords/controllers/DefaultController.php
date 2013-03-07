<?php

class DefaultController extends SController
{
    public $pageTitle = 'Ключевые слова';
    public $layout = '//layouts/writing';

    public function beforeAction($action)
    {
        if (!Yii::app()->user->checkAccess('admin'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        Yii::app()->clientScript->registerScriptFile('/js/key-ok.js');
        return true;
    }

    public function actionIndex()
    {
        $this->render('index');
    }
}