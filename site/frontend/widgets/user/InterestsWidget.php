<?php
/**
 * Author: alexk984
 * Date: 29.02.12
 */
class InterestsWidget extends UserCoreWidget
{
    public function init()
    {
        $basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
        Yii::app()->clientScript->registerScriptFile($baseUrl . '/interest.js');
        parent::init();
    }
}
