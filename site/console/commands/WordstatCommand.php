<?php
/**
 * Author: alexk984
 * Date: 11.10.12
 */

Yii::import('site.seo.models.*');
Yii::import('site.seo.models.mongo.*');
Yii::import('site.seo.components.*');
Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');

class WordstatCommand extends CConsoleCommand
{
    const WORDSTAT_LIMIT = 300;

    /**
     * Удляем из парсинга кеи, для которых частота уже определена и она < LIMIT
     */
    public function actionRemoveLowRanksFromParsing()
    {
        $criteria = new CDbCriteria;
        $criteria->limit = 100;
        $criteria->offset = 0;
        $criteria->with = array('yandex');
        $criteria->condition = 'yandex.value IS NOT NULL AND yandex.value < '.self::WORDSTAT_LIMIT;

        echo ParsingKeyword::model()->count($criteria);
    }

    public function actionSetParsed(){
        $criteria = new CDbCriteria;
        $criteria->limit = 1000;
        $criteria->offset = 0;
        $criteria->condition = 'depth IS NULL';

        $models = array(0);
        while (!empty($models)) {
            $models = ParsedKeywords::model()->findAll($criteria);

            foreach ($models as $model) {
                $yandex = YandexPopularity::model()->findByPk($model->keyword_id);
                if ($yandex !== null) {
                    $yandex->parsed = 1;
                    $yandex->save();
                }else
                    echo "error\n";
            }

            $criteria->offset += 1000;

            if ($criteria->offset % 250000 == 0)
                echo $criteria->offset."\n";
        }
    }
}