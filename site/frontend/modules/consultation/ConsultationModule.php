<?php
namespace site\frontend\modules\consultation;

/**
 * @author Никита
 * @date 26/01/15
 */

class ConsultationModule extends \CWebModule
{
    public $controllerNamespace = '\site\frontend\modules\consultation\controllers';

    public function init()
    {
        \Yii::app()->setComponent('authManager', array(
            'class' => '\site\frontend\components\AuthManager',
            'showErrors' => YII_DEBUG,
        ));
    }
}