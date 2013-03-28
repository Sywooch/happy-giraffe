<?php
/**
 * Author: alexk984
 * Date: 04.10.12
 */

Yii::import('site.seo.models.*');
Yii::import('site.seo.models.mongo.*');
Yii::import('site.seo.components.*');
Yii::import('site.seo.modules.competitors.models.*');
Yii::import('site.seo.modules.writing.models.*');
Yii::import('site.seo.modules.promotion.models.*');
Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');

class PromotionCommand extends CConsoleCommand
{
    /** Парсим статистику по ключевым словам с метрики **/
    public function actionParseVisits()
    {
        $metrica = new YandexMetrica();
        $metrica->parseQueries();
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
}