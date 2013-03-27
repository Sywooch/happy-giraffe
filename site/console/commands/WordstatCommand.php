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
                ->where('wordstat >= 10000')
                ->limit(10000)
                ->offset($i * 10000)
                ->queryColumn();

            foreach ($ids as $id) {
                ParsingKeyword::model()->updateAll(array('priority' => 255),
                    'keyword_id = :keyword_id', array(':keyword_id' => $id));
            }

            $i++;
            echo $i . "\n";
        }
    }

    public function actionFixKeywords()
    {
        $keywords = 1;
        $criteria = new CDbCriteria;
        $criteria->order = 'wordstat desc';
        $criteria->limit = 1000;

        while (!empty($keywords)) {
            $keywords = Keyword::model()->findAll($criteria);

            foreach ($keywords as $keyword) {
                $new_name = WordstatQueryModify::prepareForSave($keyword->name);
                if ($new_name != $keyword->name) {
                    $model2 = Keyword::model()->findByAttributes(array('name' => $new_name));
                    if ($model2 !== null) {
                        try {
                            $keyword->delete();
                        } catch (Exception $err) {
                            echo $err->getMessage();
                        }
                    } else {
                        $keyword->name = $new_name;
                        try {
                            $keyword->save();
                        } catch (Exception $err) {
                            echo "err_s\n";
                        }
                    }
                }
            }

            $criteria->offset += 1000;
            echo $criteria->offset . "\n";
        }
    }
}