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

class PositionCommand extends CConsoleCommand
{
    public function actionPrepare()
    {
        ParsingPosition::model()->deleteAll();
        ParsingPosition::collectKeywords();
    }

    public function actionCollectPagesKeywords()
    {
        ParsingPosition::model()->deleteAll();
        ParsingPosition::collectPagesKeywords();
    }

    public function actionParseYandex($debug = 0)
    {
        Config::setAttribute('stop_threads', 0);

        $parser = new PositionParserThread(PositionParserThread::SE_YANDEX, $debug);
        $parser->start();
    }

    public function actionParseGoogle($debug = 0)
    {
        Config::setAttribute('stop_threads', 0);

        $parser = new PositionParserThread(PositionParserThread::SE_GOOGLE, $debug);
        $parser->start();
    }

    public function actionCalcTraffic()
    {
        Yii::import('site.seo.modules.promotion.models.*');

        $se = array('google_traffic' => 3, 'yandex_traffic' => 2);
        foreach ($se as $col_name => $col_id) {
            PagesSearchPhrase::model()->updateAll(array($col_name => 0));

            $criteria = new CDbCriteria;
            $criteria->condition = 'visits > 0 AND ((week > :start_week AND year = :year) OR year > :year)';
            $criteria->params = array(
                ':start_week' => date("W", strtotime('-4 weeks')),
                ':year' => date("Y", strtotime('-4 weeks'))
            );
            $criteria->compare('se_id', $col_id);

            $models = SearchPhraseVisit::model()->findAll($criteria);
            echo count($models) . "\n";

            foreach ($models as $model) {
                $phrase = PagesSearchPhrase::model()->findByPk($model->search_phrase_id);
                $phrase->$col_name = $phrase->$col_name + $model->visits;
                $phrase->update(array($col_name));
            }
        }
    }
}