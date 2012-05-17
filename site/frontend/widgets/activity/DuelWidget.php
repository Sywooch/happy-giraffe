<?php
/**
 * Дуэль дня
 *
 * Author: choo
 * Date: 16.05.2012
 */
class DuelWidget extends CWidget
{
    public function run()
    {
        $this->registerScripts();
        $this->render('DuelWidget');
    }

    public function registerScripts()
    {
        $basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
        Yii::app()->clientScript->registerScriptFile($baseUrl . '/duel.js');
        parent::init();
    }
}
