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
    const WORDSTAT_LIMIT = 200;

    public function actionAddKeywords()
    {
        $criteria = new CDbCriteria;
        $criteria->limit = 1000;
        $criteria->with = array('yandex');
        $criteria->order = 'id asc';

        $i = 0;
        $models = array(1);
        while (!empty($models)) {
            $models = Keyword::model()->findAll($criteria);
            foreach ($models as $model) {
                if (!isset($model->yandex)) {
                    $parsing = new ParsingKeyword();
                    $parsing->keyword_id = $model->id;
                    try {
                        $parsing->save();
                    } catch (Exception $e) {

                    }
                }
                $last_id = $model->id;
            }
            $criteria->condition = 'id > ' . $last_id;

            $i++;
            if ($i % 100 == 0)
                echo round($i / 10) . "\n";
        }
    }

    public function actionAddCompetitors()
    {
        $keywords = Yii::app()->db_seo->createCommand('select distinct(keyword_id) from sites__keywords_visits ')->queryColumn();
        $count = 0;
        foreach ($keywords as $keyword_id)
            if (ParsingKeyword::addKeyword($keyword_id))
                $count++;
    }

    public function actionAddKeywordsFromFile()
    {
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
        Yii::import('site.common.models.mongo.*');

        $path = Yii::app()->params['keywords_path'];
        $handle = @fopen($path, "r");
        $i = 0;
        $start_line = UserAttributes::get(1, 'start_file_line', 3800000);
        while (($buffer = fgets($handle)) !== false) {
            $i++;
            if ($i < $start_line)
                continue;

            $keyword = trim(substr($buffer, 0, strpos($buffer, ',')));
            $keyword_model = Keyword::model()->findByAttributes(array('name' => $keyword));
            if ($keyword_model === null) {
                $keyword_model = new Keyword();
                $keyword_model->name = $keyword;
                try {
                    $keyword_model->save();
                    ParsingKeyword::addNewKeyword($keyword_model, 0);
                } catch (Exception $e) {
                }
            }
            if ($i % 10000 == 0) {
                echo $i . "\n";
                UserAttributes::set(1, 'start_file_line', $i);
            }
        }
        fclose($handle);
    }

    public function actionTest(){
        $parser = new WordstatParser();
        $parser->start(false);
    }
}