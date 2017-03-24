<?php

namespace site\frontend\modules\iframe\modules\specialists;

/**
 * @author Никита
 * @date 12/08/16
 */
class SpecialistsModule extends \CWebModule
{
    public $controllerNamespace = 'site\frontend\modules\iframe\modules\specialists\controllers';

    public function init()
    {
        \Yii::app()->setComponent('authManager', array(
            'class' => '\site\frontend\components\AuthManager',
        ));
        //\Yii::app()->clientScript->registerPackage('pediatrician-iframe');
//        $this->setModules([
//            'pediatrician' => [
//                'class' => 'site\frontend\modules\specialists\modules\pediatrician\PediatricianModule',
//            ],
//        ]);
    }
}