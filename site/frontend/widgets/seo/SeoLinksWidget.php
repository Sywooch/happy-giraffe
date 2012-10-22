<?php
/**
 * Author: alexk984
 * Date: 15.05.12
 */
class SeoLinksWidget extends CWidget
{
    public function run()
    {
        if (!Yii::app()->user->isGuest)
            return;
        Yii::import('site.seo.models.*');
        Yii::import('site.seo.modules.promotion.models.*');

        echo InnerLinksBlock::model()->getHtmlByUrl($this->getUrl());
    }

    public function getUrl()
    {
        return 'http://www.happy-giraffe.ru' . Yii::app()->request->getRequestUri();
    }
}