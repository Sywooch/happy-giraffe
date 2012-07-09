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

    public function actionPreparePositionParsing(){
        Yii::app()->db_seo->createCommand('update queries set yandex_parsed = 0, google_parsed = 0, parsing = 0;')->execute();
    }

    public function actionParseQueriesYandex()
    {
        Config::setAttribute('stop_threads', 0);

        $parser = new PositionParserThread(PositionParserThread::SE_YANDEX);
        $parser->start();
    }

    public function actionParseQueriesGoogle()
    {
        Config::setAttribute('stop_threads', 0);

        $parser = new PositionParserThread(PositionParserThread::SE_GOOGLE);
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
}

