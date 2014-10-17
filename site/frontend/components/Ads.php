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
        if ($this->isProduction()) {
            Yii::app()->controller->renderPartial('//counters/counters');
        }
    }

    public function addNoindex()
    {
        if (! $this->isProduction()) {
            Yii::app()->clientScript->registerMetaTag('noindex,nofollow', 'robots', null, array('develop' => 'develop'));
        }
    }

    public function addVerificationTags()
    {
        if ($this->isProduction()) {
            Yii::app()->clientScript->registerMetaTag('NWGWm2TqrA1HkWzR8YBwRT08wX-3SRzeQIBLi1PMK9M', 'google-site-verification');
            Yii::app()->clientScript->registerMetaTag('41ad6fe875ade857', 'yandex-verification');
        }
    }

    protected function isProduction()
    {
        return $_SERVER['HTTP_HOST'] == 'www.happy-giraffe.ru';
    }
} 