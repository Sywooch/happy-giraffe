<?php

/*
 * Iframe приложение для партнеров
 */
class IframeModule extends \CWebModule
{
    public function init()
    {
        // Используем новый AuthManager
        \Yii::app()->setComponent('authManager', array(
            'class' => '\site\frontend\components\AuthManager',
        ));
        \Yii::app()->clientScript->registerPackage('iframe');

        // Cписок модулей
        $this->setModules([
            'userProfile' => [
                'class' => 'site\frontend\modules\iframe\modules\userProfile\UserProfileModule',
            ],
            'specialists' => [
                'class' => 'site\frontend\modules\iframe\modules\specialists\SpecialistsModule',
            ],
            'family' => [
                'class' => 'site\frontend\modules\iframe\modules\family\FamilyModule',
            ],
            'notifications' => [
                'class' => 'site\frontend\modules\iframe\modules\notifications\NotificationsModule',
            ],
        ]);
    }
}
