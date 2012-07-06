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

        $page = self::getPage();
        if ($page !== null && isset($page->outputLinks) && !empty($page->outputLinks))
            $this->render('index', array('link_pages'=>$page->outputLinks));
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