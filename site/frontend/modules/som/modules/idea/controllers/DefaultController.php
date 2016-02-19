<?php

namespace site\frontend\modules\som\modules\idea\controllers;

use site\frontend\modules\som\modules\idea\models\Idea;
use site\frontend\modules\photo\models\api\Attach;
use site\frontend\modules\photo\models\api\Collection;


class DefaultController extends \LiteController
{
    public $litePackage = 'member';
    //public $layout = '/layouts/main';
    public $bodyClass = 'body__lite';

    public function actionIndex()
    {
        $cs = \Yii::app()->clientScript;
        $cs->useAMD = false;
        $cs->registerPackage('lite_services');
        $cs->useAMD = true;
        $this->render('index');
    }

    public function actionMyIdeas($id)
    {
        //why?
        $this->render('my');
    }
}