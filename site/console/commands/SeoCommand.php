<?php
/**
 * Author: alexk984
 * Date: 13.03.12
 */

Yii::import('site.seo.models.*');
Yii::import('site.seo.models.mongo.*');
Yii::import('site.seo.components.*');
Yii::import('site.seo.modules.competitors.models.*');
Yii::import('site.seo.modules.writing.models.*');
Yii::import('site.seo.modules.promotion.models.*');
Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');

class SeoCommand extends CConsoleCommand
{
    public function actionParseSeVisits()
    {
        $metrica = new YandexMetrica();
        $metrica->parseQueries();
        $metrica->convertToSearchPhraseVisits();
    }

    public function actionParseDataForSe()
    {
        $metrica = new YandexMetrica();
        $metrica->parseDataForAllSE();
    }

    public function actionConvertVisits()
    {
        $metrica = new YandexMetrica();
        $metrica->convertToSearchPhraseVisits();
    }

    public function actionConvertPrevVisits($week)
    {
        $metrica = new YandexMetrica($week);
        $metrica->convertToSearchPhraseVisits();
    }

    public function actionParseMonthTraffic()
    {
        $metrica = new YandexMetrica(1);
        $metrica->parseQueries();
        $metrica->convertToSearchPhraseVisits();

        $metrica = new YandexMetrica(2);
        $metrica->parseQueries();
        $metrica->convertToSearchPhraseVisits();

        $metrica = new YandexMetrica(3);
        $metrica->parseQueries();
        $metrica->convertToSearchPhraseVisits();
    }

    public function actionWeekTraffic($week)
    {
        $metrica = new YandexMetrica($week);
        $metrica->parseQueries();
        $metrica->convertToSearchPhraseVisits();
    }

    public function actionStopThreads()
    {
        Config::setAttribute('stop_threads', 1);
    }

    public function actionPreparePositionParsing()
    {
        Yii::app()->db_seo->createCommand('update queries set yandex_parsed = 0, google_parsed = 0, parsing = 0;')->execute();
    }

    public function actionParseQueriesYandex($debug = 0)
    {
        Config::setAttribute('stop_threads', 0);

        $parser = new PositionParserThread(PositionParserThread::SE_YANDEX, $debug);
        $parser->start();
    }

    public function actionParseQueriesGoogle($debug = 0)
    {
        Config::setAttribute('stop_threads', 0);

        $parser = new PositionParserThread(PositionParserThread::SE_GOOGLE, $debug);
        $parser->start();
    }

    public function actionWordstat($mode = 0)
    {
        $parser = new WordstatParser();
        $parser->start($mode);
    }

    public function actionCalculateMain()
    {
        $metrica = new YandexMetrica();
        $metrica->calculateMain();
    }

    public function actionDelete1Visits()
    {
        $metrica = new YandexMetrica();
        $metrica->delete1Visits();
    }

    public function actionAddSeVisitsToWordStat()
    {
        $se = PagesSearchPhrase::model()->findAll();

        foreach ($se as $phrase) {
            $parsed = ParsedKeywords::model()->find('keyword_id =' . $phrase->keyword_id);
            if ($parsed !== null)
                continue;

            $model = ParsingKeyword::model()->find('keyword_id =' . $phrase->keyword_id);
            if ($model === null) {
                $parse = new ParsingKeyword();
                $parse->keyword_id = $phrase->keyword_id;
                $parse->depth = 1;
                $parse->priority = 5;
                if (!$parse->save()) {
                    var_dump($parse->getErrors());
                    Yii::app()->end();
                }
            } else {
                $model->priority = 5;
                $model->save();
            }
        }
    }

    public function actionAddUrls()
    {
        Yii::import('site.seo.modules.indexing.components.*');
        Yii::import('site.seo.modules.indexing.models.*');
        Yii::import('site.frontend.components.CutBehavior');

        $urlCollector = new UrlCollector;
        $urlCollector->collectUrls();
    }

    public function actionDropUrls()
    {
        Yii::import('site.seo.modules.indexing.components.*');
        Yii::import('site.seo.modules.indexing.models.*');
        Yii::import('site.frontend.components.CutBehavior');

        $urlCollector = new UrlCollector;
        $urlCollector->removeUrls();
    }

    public function actionRefreshParsing()
    {
        Yii::app()->db_seo->createCommand('update proxies set active = 0')->execute();
        Yii::app()->db_seo->createCommand('update indexing__urls set active = 0')->execute();
    }

    public function actionRestartParsing()
    {
        Yii::app()->db_seo->createCommand('update proxies set active = 0')->execute();
        Yii::app()->db_seo->createCommand('update indexing__urls set active = 0 where active = 1')->execute();
    }

    public function actionParseIndex()
    {
        Yii::import('site.seo.modules.indexing.components.*');
        Yii::import('site.seo.modules.indexing.models.*');
        Config::setAttribute('stop_threads', 0);

        $parser = new IndexParserThread();
        $parser->start();
    }

    public function actionAddUp()
    {
        Yii::import('site.seo.modules.indexing.components.*');
        Yii::import('site.seo.modules.indexing.models.*');

        $model = new IndexingUp();
        $model->date = date("Y-m-d");
        echo $model->save();
    }

    public function actionImportVisits()
    {
        Yii::import('site.seo.modules.competitors.models.*');

        $criteria = new CDbCriteria;
        $criteria->limit = 100;
        $criteria->offset = 0;

        $i = 0;
        $models = array(0);
        while (!empty($models)) {
            $models = SitesKeywordsVisit2::model()->findAll($criteria);

            foreach ($models as $model) {
                $model2 = new SiteKeywordVisit();
                $model2->attributes = $model->attributes;
                $model2->keyword_id = Keyword::GetKeyword($model->keyword)->id;
                $model2->save();
            }

            $i++;
            $criteria->offset = $i * 100;
        }
    }

    public function actionProxy()
    {
        ProxyRefresher::execute();
    }

    public function actionAddToParsing()
    {
        $criteria = new CDbCriteria;
        $criteria->limit = 1000;

        $i = 0;
        $visits = array(1);
        while (!empty($visits)) {
            $criteria->offset = 1000 * $i;

            $visits = SiteKeywordVisit::model()->findAll($criteria);
            foreach ($visits as $visit) {
                $parsed = ParsedKeywords::model()->find('keyword_id =' . $visit->keyword_id);
                if ($parsed !== null && empty($parsed->depth))
                    continue;

                $model = ParsingKeyword::model()->find('keyword_id =' . $visit->keyword_id);
                if ($model === null) {
                    $parse = new ParsingKeyword();
                    $parse->keyword_id = $visit->keyword_id;
                    $parse->priority = 4;
                    if (!$parse->save()) {
                        var_dump($parse->getErrors());
                        Yii::app()->end();
                    }
                } else {
                    $model->priority = 4;
                    $model->save();
                }
            }
            $i++;
        }
    }

    public function actionFix()
    {
        $criteria = new CDbCriteria;
        $criteria->limit = 1000;
        $criteria->with = array(
            'yandex' => array(
                'condition' => 'value < 100'
            )
        );

        $i = 0;
        $models = array(1);
        while (!empty($models)) {
            $criteria->offset = 1000 * $i;

            $models = ParsingKeyword::model()->findAll($criteria);
            foreach ($models as $model) {
                $parsed = new ParsedKeywords;
                $parsed->keyword_id = $model->keyword_id;
                try {
                    $parsed->save();
                } catch (Exception $err) {
                }
                $model->delete();
            }

            $i++;
            echo $i . "\n";
        }
    }

    public function actionProxyMongo()
    {
        $criteria = new CDbCriteria;
        $criteria->limit = 1000;
        $i = 0;
        $proxies = array(1);
        while (!empty($proxies)) {
            $criteria->offset = 1000 * $i;

            $proxies = Proxy::model()->findAll($criteria);
            foreach ($proxies as $proxy) {
                $mongo_proxy = new ProxyMongo;
                $mongo_proxy->value = $proxy->value;
                $mongo_proxy->rank = $proxy->rank;
                $mongo_proxy->created = strtotime($proxy->created);
                $mongo_proxy->save();
            }

            $i++;
        }
    }

    public function actionProxyMongoCheck()
    {
        $start_time = microtime(true);
        $criteria = new EMongoCriteria;
        $criteria->active('==', 0);
        $criteria->sort('rank', EMongoCriteria::SORT_DESC);
        $criteria->sort('created', EMongoCriteria::SORT_DESC);
        ProxyMongo::model()->find($criteria);

        echo 1000 * (microtime(true) - $start_time);
    }

    public function actionAddPages()
    {

//        $keyword = Keyword::GetKeyword('Календарь беременности');
//        $group = new KeywordGroup();
//        $group->keywords = array($keyword->id);
//        $group->save();
//        $page = new Page();
//        $page->url = 'http://www.happy-giraffe.ru/pregnancyCalendar/';
//        $page->keyword_group_id = $group->id;
//        if ($page->save())
//            echo "success \n";
    }

    public function actionCalcGoogleVisits(){
        Yii::import('site.seo.modules.promotion.models.*');

        $criteria = new CDbCriteria;
        $criteria->condition = 'visits > 0';
        $criteria->compare('week', date("W") - 1);
        $criteria->compare('year', date("Y", strtotime('-1 week')));
        $criteria->compare('se_id', 3);

        $models = SearchPhraseVisit::model()->findAll($criteria);
        PagesSearchPhrase::model()->updateAll(array('google_traffic'=>0));

        foreach($models as $model){
            echo $model->visits."\n";
            $model->phrase->google_traffic = $model->visits;
            $model->phrase->update(array('google_traffic'));
        }
    }
}

