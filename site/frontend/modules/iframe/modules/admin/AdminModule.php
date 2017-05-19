<?php

namespace site\frontend\modules\iframe\modules\admin;

class AdminModule extends \CWebModule
{
    public $controllerNamespace = 'site\frontend\modules\iframe\modules\admin\controllers';

    public function init()
    {
        \Yii::app()->clientScript->registerPackage('pediatrician-iframe');
    }
}
