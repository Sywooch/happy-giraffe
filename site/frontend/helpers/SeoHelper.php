<?php
/**
 * Author: alexk984
 * Date: 15.05.12
 */
class SeoHelper
{
    public static function getLinkBock()
    {
        Yii::import('site.seo.models.*');
        Yii::import('site.seo.modules.promotion.models.*');

        $str = '';
        $page = self::getPage();
        if (!empty($page) && !empty($page->outputLinks)) {
            foreach ($page->outputLinks as $link_page) {
                $str.= CHtml::link($link_page->keyword->name, $link_page->pageTo->url);
            }
        }

        return $str;
    }

    /**
     * @static
     * @return Page
     */
    static function getPage()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('url', 'http://www.happy-giraffe.ru'.Yii::app()->request->getRequestUri());
        return Page::model()->find($criteria);
    }
}