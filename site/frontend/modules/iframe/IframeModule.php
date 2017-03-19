<?php

/*
 * Iframe приложение для партнеров
 */
class IframeModule extends \CWebModule
{
    public function init()
    {
        Yii::app()->clientScript->registerCssFile('http://www.happy-giraffe.ru/stylesheets/maintenance.css');

        // Используем новый AuthManager
        \Yii::app()->setComponent('authManager', array(
            'class' => '\site\frontend\components\AuthManager',
        ));
    }
}
