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

        $html = $this->getCachedHtml();
        echo $html;
    }

    public function getCachedHtml()
    {
        $cache_id = 'inner_links_' . urlencode($this->getUrl());
        $html = Yii::app()->cache->get('temporary_' . $cache_id);
        if ($html === false) {
            $html = $this->getHtml();

            if ($html !== false) {
                Yii::app()->cache->set($cache_id, $html);
                Yii::app()->cache->set('temporary_' . $cache_id, $html, 24 * 3600);
            } else {
                $html = Yii::app()->cache->get($cache_id);
                if ($html === false)
                    $html = '';
            }
        }

        return $html;
    }

    public function getHtml()
    {
        try {
            $page = $this->getPage();
            if ($page !== null && !empty($page->outputLinks))
                $html = $this->render('index', array('link_pages' => $page->outputLinks), true);
            else
                $html = '';
        } catch (Exception $err) {
            $html = false;
        }

        return $html;
    }

    /**
     * @return Page
     */
    public function getPage()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('url', $this->getUrl());
        return Page::model()->find($criteria);
    }

    public function getUrl()
    {
        return 'http://www.happy-giraffe.ru' . Yii::app()->request->getRequestUri();
    }
}