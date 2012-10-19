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

    public function actionAddSeVisitsToWordStat()
    {
        $se = PagesSearchPhrase::model()->findAll();

        foreach ($se as $phrase) {
            $yandex = YandexPopularity::model()->find('keyword_id =' . $phrase->keyword_id);
            if ($yandex !== null && $yandex->parsed == 1)
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
                $yandex = YandexPopularity::model()->find('keyword_id =' . $visit->keyword_id);
                if ($yandex !== null && $yandex->parsed == 1)
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

    public function actionProxyCheck()
    {
        $start_time = microtime(true);
        $criteria = new CDbCriteria();
        $criteria->compare('active', 0);
        $criteria->order = 'rank desc';
        $model = Proxy::model()->find($criteria);

        echo 1000 * (microtime(true) - $start_time) . "\n";
        $start_time = microtime(true);

        $model->rank = 4;
        $model->save();

        echo 1000 * (microtime(true) - $start_time) . "\n";
        $start_time = microtime(true);

        $model->delete();

        echo 1000 * (microtime(true) - $start_time) . "\n";
    }

    public function actionDeletePageDuplicates()
    {
        Yii::import('site.common.behaviors.*');
        $criteria = new CDbCriteria;
        $criteria->limit = 1000;
        $criteria->offset = 0;

        $models = array(0);
        while (!empty($models)) {
            $models = Page::model()->findAll($criteria);

            foreach ($models as $model) {
                $criteria2 = new CDbCriteria;
                $criteria2->compare('url', $model->url);
                $criteria2->order = 'id asc';
                $samePages = Page::model()->findAll($criteria2);
                if (count($samePages) > 1) {
                    echo $model->url . ' - ' . count($samePages) . "\n";

                    $first = true;
                    foreach ($samePages as $samePage) {
                        echo $samePage->outputLinksCount . ' : ' . $samePage->inputLinksCount
                            . ' : ' . $samePage->taskCount . ' : ' . $samePage->phrasesCount
                            . ' : ' . $samePage->keywordGroup->taskCount
                            . ' : ' . count($samePage->keywordGroup->keywords). "\n";

//                        if ($samePage->outputLinksCount == 0
//                            && $samePage->inputLinksCount == 0
//                            && $samePage->taskCount == 0
//                            && $samePage->phrasesCount == 0
//                            && empty($samePage->keywordGroup->keywords)
//                            && $samePage->keywordGroup->taskCount == 0
//                        ) {
                            if (!$first)
                                $samePage->delete();
//                        }

                        $first = false;
                    }
                }
            }

            echo $criteria->offset . "\n";
            $criteria->offset += 900;
        }
    }

    public function actionCheckEntities(){
        $criteria = new CDbCriteria;
        $criteria->limit = 100;
        $criteria->offset = 0;

        $models = array(0);
        while (!empty($models)) {
            $models = Page::model()->findAll($criteria);

            foreach ($models as $model) {
                list($entity, $entity_id) = Page::ParseUrl($model->url);

                if (!empty($entity) && !empty($entity_id) && $entity != $model->entity){
                    echo $entity."\n";
                    $model->entity = $entity;
                    $model->entity_id = $entity_id;
                    $model->save();
                }
            }

            $criteria->offset += 100;
        }
    }

    public function actionMailru(){
        Yii::import('site.seo.modules.mailru.components.*');

        $parser = new MailRuUserParser;
        $parser->start();
    }

    public function actionMailruCollect(){
        Yii::import('site.seo.modules.mailru.components.*');

        MailRuContestParser::collectContests();
    }
}

