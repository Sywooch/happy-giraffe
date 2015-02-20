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
        
        \Yii::app()->setComponent('authManager', array(
            'class' => '\site\frontend\components\AuthManager',
        ));
        
        \Yii::app()->clientScript->useAMD = true;
        /** @todo так не делать */
        \Yii::app()->clientScript->registerCssFile("/lite/css/dev/all.css");

        $this->setModules(array(
            'contest' => array(
                'class' => 'site\frontend\modules\comments\modules\contest\CommentatorsContestModule',
            ),
        ));
    }

}
