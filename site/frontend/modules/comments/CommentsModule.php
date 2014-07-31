<?php

namespace site\frontend\modules\comments;

/**
 * Модуль нужен исключительно для тестирования. Работает только при включеном YII_DEBUG
 */
class CommentsModule extends \CWebModule
{

    public $controllerNamespace = 'site\frontend\modules\comments\controllers';

    public function init()
    {
        \Yii::app()->clientScript->useAMD = true;
    }

    public function beforeControllerAction($controller, $action)
    {
        if (parent::beforeControllerAction($controller, $action))
            return YII_DEBUG;
        else
            return false;
    }

}
