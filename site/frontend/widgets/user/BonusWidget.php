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
        $scores = $this->user->score;
        if ($this->user->id != Yii::app()->user->id || $scores->full == 2)
            return;

        if ($scores->full == 1) {
            $scores->full = 2;
            $scores->level_id = 1;
            $scores->save('full');

            $this->render('BonusWidgetSuccess');
        } else {
            $this->registerScript();
            Yii::import('site.common.models.forms.DateForm');

            $this->render('BonusWidget');
        }
    }

    private function registerScript()
    {
        $basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
        Yii::app()->clientScript->registerScriptFile($baseUrl . '/bonus.js?r=2');
    }
}