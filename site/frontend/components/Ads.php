<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 21/07/14
 * Time: 15:58
 */

class Ads extends CApplicationComponent
{
    public $showAds = false;

    public function showAd($alias)
    {
        if ($this->showAds) {
            Yii::app()->controller->renderPartial($alias);
        }
    }

    public function showCounters()
    {
        if ($_SERVER['HTTP_HOST'] == 'www.happy-giraffe.ru') {
            Yii::app()->controller->renderPartial('//counters/counters');
        }
    }
} 