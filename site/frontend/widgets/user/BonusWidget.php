<?php
/**
 * Author: alexk984
 * Date: 31.07.12
 */
class BonusWidget extends UserCoreWidget
{
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        Yii::import('site.common.models.forms.DateForm');
        if ($this->user->id != Yii::app()->user->id || $this->user->bonus != 0)
            return ;

        $this->render('BonusWidget');

        $basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
        Yii::app()->clientScript->registerScriptFile($baseUrl . '/bonus.js');
    }
}