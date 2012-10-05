<?php
/**
 * Author: alexk984
 * Date: 05.10.12
 */

Yii::import('site.seo.models.*');
Yii::import('site.seo.components.*');
Yii::import('site.seo.models.mongo.*');
Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');

class LinkingCommand extends CConsoleCommand
{
    public function actionPrepareParsing(){
        $kewords = Yii::app()->db_seo->createCommand()
            ->selectDistinct('keyword_id')
            ->from('pages_search_phrases')
            ->where('last_yandex_position < 1000 OR google_traffic > 0')
            ->queryColumn();

        foreach($kewords as $keword){
            $model = new YandexSearchKeyword;
            $model->keyword_id = $keword;
            $model->save();
        }
    }

    public function actionParse()
    {
        Config::setAttribute('stop_threads', 0);

        $parser = new SearchResultsParser();
        $parser->start();
    }
}