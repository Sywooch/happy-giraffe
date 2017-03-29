<?php

namespace site\frontend\modules\iframe\modules\notifications;

class NotificationsModule extends \CWebModule
{

    public $controllerNamespace = 'site\frontend\modules\iframe\modules\notifications\controllers';

    public function init()
    {
        // this method is called when the module is being created
        // you may place code here to customize the module or the application
        // import the module-level models and components
        $this->setImport(array(
            'iframe.modules.notifications.models.*',
            'iframe.modules.notifications.components.*',
        ));
        \Yii::app()->clientScript->registerPackage('lite_notification-iframe');
        \Yii::app()->clientScript->registerPackage('lite_pediatrician-iframe');
        \Yii::app()->clientScript->useAMD = true;
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
