<?php
/**
 * Author: alexk984
 * Date: 27.12.12
 */

class AjaxSimpleController extends CController
{
    public function filters()
    {
        return array(
            'ajaxOnly - socialVote',
        );
    }

    public function actionCounter(){
        Yii::import('site.seo.models.*');

        $referrer = Yii::app()->request->getPost('referrer');
        $page_url = Yii::app()->request->urlReferrer;
        if (empty($referrer) || empty($page_url) || strpos('http://www.happy-giraffe.ru/', $referrer) === 0)
            Yii::app()->end();

        if (strpos($referrer, 'http://') === 0)
            $referrer = str_replace('http://', '', $referrer);
        if (strpos($referrer, 'https://') === 0)
            $referrer = str_replace('https://', '', $referrer);
        if (strpos($referrer, 'www.') === 0)
            $referrer = str_replace('www.', '', $referrer);

        $se_list = SearchEngine::model()->cache(3600)->findAll();
        foreach($se_list as $se)
            if (strpos($referrer, $se->url) === 0){
//                $page = Page::getPage($page_url);
//                if ($page && in_array($page->entity , array('CommunityContent','BlogContent', 'CookRecipe')))
//                    SearchEngineVisits::addVisit($page->id);

                PageSearchView::model()->inc($page_url);
            }
    }
}