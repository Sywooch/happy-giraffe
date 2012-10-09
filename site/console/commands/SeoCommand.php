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
        $criteria = new CDbCriteria;
        $criteria->limit = 100;
        $criteria->offset = 0;

        $i = 0;
        $models = array(0);
        while (!empty($models)) {
            $models = Page::model()->findAll($criteria);

            foreach ($models as $model) {
                $criteria2 = new CDbCriteria;
                $criteria2->compare('url', $model->url);
                $criteria2->order = 'id asc';
                $samePages = Page::model()->findAllByAttributes(array('url' => $model->url));
                if (count($samePages) > 1) {
                    echo $model->url . ' - ' . count($samePages) . "\n";
                    Page::model()->deleteAll('id>' . $samePages[0]->id);
                }
            }

            $i++;
            $criteria->offset = $i * 100;
            if ($i % 10 == 0)
                echo $i."\n";
        }
    }
}

