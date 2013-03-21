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

    public function actionModify($num = 1)
    {
        $parser = new WordstatQueryModify();
        $parser->addToParsing($num);
    }

    public function actionFixPriority($i = 0)
    {
        $ids = 1;
        while (!empty($ids)) {
            $ids = Yii::app()->db_keywords->createCommand()
                ->select('id')
                ->from('keywords')
                ->where('wordstat > 10000')
                ->limit(10000)
                ->offset($i * 10000)
                ->queryColumn();

            foreach ($ids as $id) {
                $model = ParsingKeyword::model()->findByPk($id);
                if ($model !== null) {
                    if (strtotime($model->updated) < strtotime('-5 days')) {
                        $model->priority = 100;
                        $model->update(array('priority'));
                    }
                } else {
                    $model = new ParsingKeyword;
                    $model->keyword_id = $id;
                    $model->priority = 100;
                    $model->save();
                }
            }

            $i++;
            echo $i . "\n";
        }
    }
}