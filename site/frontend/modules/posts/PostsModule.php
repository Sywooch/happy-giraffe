<?php

namespace site\frontend\modules\posts;

/**
 * Description of PostsModule
 *
 * @author Кирилл
 */
class PostsModule extends \CWebModule
{

    public $controllerNamespace = 'site\frontend\modules\posts\controllers';

    public function init()
    {

        \Yii::app()->setComponent('authManager', array(
            'class' => '\site\frontend\components\AuthManager',
        ));
        $this->setModules(array(
            'myGiraffe' => array(
                'class' => 'site\frontend\modules\posts\modules\myGiraffe\MyGiraffeModule',
            ),
            'onAir' => array(
                'class' => 'site\frontend\modules\posts\modules\onAir\OnAirModule',
            ),
            'photoAds' => array(
                'class' => 'site\frontend\modules\posts\modules\photoAds\PhotoAdsModule',
            ),
        ));
    }

}

?>
