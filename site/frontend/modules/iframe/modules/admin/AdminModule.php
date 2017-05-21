<?php

namespace site\frontend\modules\iframe\modules\admin;

class AdminModule extends \CWebModule
{
    public $controllerNamespace = 'site\frontend\modules\iframe\modules\admin\controllers';

    public function init()
    {
        \Yii::app()->cache->flush();
        \Yii::app()->clientScript->registerPackage('pediatrician-iframe');
    }

    public function beforeControllerAction($controller, $action)
    {
        if (parent::beforeControllerAction($controller, $action))
        {
            // this method is called before any module controller action is performed
            // you may place customized code here
            return true;
        }
        else
            return false;
    }
}
