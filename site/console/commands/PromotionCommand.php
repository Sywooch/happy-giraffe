<?php
/**
 * Author: alexk984
 * Date: 04.10.12
 */

Yii::import('site.seo.models.*');
Yii::import('site.seo.models.mongo.*');
Yii::import('site.seo.components.*');
Yii::import('site.seo.components.wordstat.*');
Yii::import('site.seo.modules.competitors.models.*');
Yii::import('site.seo.modules.writing.models.*');
Yii::import('site.seo.modules.promotion.models.*');
Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
Yii::import('site.common.models.mongo.*');

class PromotionCommand extends CConsoleCommand
{
    /** Парсим статистику по ключевым словам с метрики **/
    public function actionParseVisits()
    {
        $metrica = new YandexMetrica();
        $metrica->parseQueries();
    }

    public function actionTest()
    {
        PageStatistics::model()->parseSe();
    }

    public function actionParseDepth()
    {
        $metrica = new YandexMetrica();
        $metrica->parseDepthFirstRows();
    }

    public function actionExport(){
        PageStatistics::model()->export();
    }

    /** Готовим парсинг позиций слов по которым заходили за последнюю неделю **/
    public function actionPrepare()
    {
        ParsingPosition::model()->deleteAll();
        ParsingPosition::collectKeywords();
    }

    /** Готовим парсинг позиций **/
    public function actionCollectPagesKeywords()
    {
        ParsingPosition::model()->deleteAll();
        ParsingPosition::collectPagesKeywords();
    }

    /** Парсинг позиций в Яндексе **/
    public function actionYandex($debug = 0)
    {
        $parser = new PositionParserThread(PositionParserThread::SE_YANDEX, $debug);
        $parser->start();
    }

    /** Парсинг позиций в Google **/
    public function actionGoogle($debug = 0)
    {
        $parser = new PositionParserThread(PositionParserThread::SE_GOOGLE, $debug);
        $parser->start();
    }

    public function actionPageViews()
    {
        Yii::import('site.frontend.helpers.*');
        $pages = PagePromotion::model()->findAll();
        foreach ($pages as $page) {
            $url = str_replace('http://www.happy-giraffe.ru', '', $page->url);
            $page->views = GApi::model()->uniquePageViews($url, '2012-01-01', '2013-04-12', false);
            echo $url . ' - ' . $page->views . "\n";
            $page->save();
        }
    }

    public function actionViews()
    {
        Yii::import('site.frontend.helpers.*');
        $criteria = new EMongoCriteria();
        $criteria->addCond('views', '==', null);
        $pages = PagePromotion::model()->findAll($criteria);
        foreach ($pages as $page) {
            $url = str_replace('http://www.happy-giraffe.ru', '', $page->url);
            $page->views = GApi::model()->uniquePageViews($url, '2011-01-01', '2013-04-12', false);
            echo $url . ' - ' . $page->views . "\n";
            $page->update(array('views'));
        }
    }

    public function actionAddToParsing()
    {
        $pages = PagePromotion::model()->findAll();
        foreach ($pages as $page) {
            $page2 = Page::model()->findByAttributes(array('url' => $page->url));
            if ($page2 === null) {
                $page2 = new Page;
                $page2->url = $page->url;
                $page2->save();
            }
            $phrase = PagesSearchPhrase::model()->findByAttributes(array(
                'page_id' => $page2->id,
                'keyword_id' => $page->keyword_id,
            ));
            if ($phrase === null) {
                $phrase = new PagesSearchPhrase;
                $phrase->page_id = $page2->id;
                $phrase->keyword_id = $page->keyword_id;
                $phrase->save();
            }
            $model = new ParsingPosition;
            $model->keyword_id = $page->keyword_id;
            $model->save();

        }
    }
}