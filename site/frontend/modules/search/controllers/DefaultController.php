<?php

class DefaultController extends LiteController
{

    public $showAddBlock = false;

    public $litePackage = 'services';

    public function actionIndex()
    {
        Yii::app()->clientScript->useAMD = true;
//        if(!Yii::app()->user->isGuest)
//            $this->layout = '//layouts/new/main';
        $this->render('yandex');
    }
}