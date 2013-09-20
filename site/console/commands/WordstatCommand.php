<?php
Yii::import('site.seo.models.*');
Yii::import('site.seo.models.mongo.*');
Yii::import('site.seo.components.*');
Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
Yii::import('site.seo.components.wordstat.*');

/**
 * Class WordstatCommand
 *
 * Парсинг wordstat
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class WordstatCommand extends CConsoleCommand
{
    const WORDSTAT_LIMIT = 200;

    /**
     * Добавление задач на парсинг, висит все время после запуска и добавляет задания
     */
    public function actionPutTask()
    {
        $job_provider = new WordstatTaskCreator;
        $job_provider->start('simple_parsing');
    }

    /**
     * Добавление приоритетных задач на парсинг
     */
    public function actionPutImportantTask()
    {
        $job_provider = new WordstatTaskCreator;
        $job_provider->start('important_parsing');
    }

    /**
     * Добавление ключевых слов на парсинг сезонности
     */
    public function actionPutSeasonTask()
    {
        $job_provider = new WordstatTaskCreator;
        $job_provider->start('season_parsing');
    }

    /**
     * Поток простого парсинга wordstat
     */
    public function actionSimple()
    {
        $p = new WordstatParser();
        $p->start();
    }

    /**
     * Поток парсинга сезонности wordstat
     */
    public function actionSeason()
    {
        $p = new WordstatSeasonParser();
        $p->start();
    }

    /**
     * Добавление ключевых слов на парсинг сезонности
     */
    public function actionAddToSeasonParsing()
    {
        WordstatParsingTask::getInstance()->addAllKeywordsToSeasonParsing();
    }
}