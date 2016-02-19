<?php

namespace site\frontend\modules\som\modules\idea\controllers;

class FormController extends \LiteController
{
    public $litePackage = 'member';
    //public $layout = '/layouts/main';
    public $bodyClass = 'body__lite';

    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('deny',
                'users' => array('?'),
                'actions' => array('create'),
            ),
        );
    }

    public function actionCreate()
    {
        $cs = \Yii::app()->clientScript;
        $cs->useAMD = false;
        $cs->registerPackage('lite_services');
        $cs->useAMD = true;
        $this->render('create');
    }

}