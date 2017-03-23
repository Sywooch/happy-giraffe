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
    }
}
