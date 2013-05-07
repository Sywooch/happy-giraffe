<?php
/**
 * Author: alexk984
 * Date: 11.10.12
 */

Yii::import('site.seo.models.*');
Yii::import('site.seo.models.mongo.*');
Yii::import('site.seo.components.*');
Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
Yii::import('site.seo.components.wordstat.*');

class WordstatCommand extends CConsoleCommand
{
    const WORDSTAT_LIMIT = 200;

    public function actionAddCompetitors()
    {
        $keywords = Yii::app()->db_seo->createCommand('select distinct(keyword_id) from sites__keywords_visits ')->queryColumn();
        echo count($keywords);
        foreach ($keywords as $keyword_id) {

        }
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
                    #TODO add to parsing queue
                    //ParsingKeyword::addNewKeyword($keyword_model);
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

    public function actionFixPriority($i = 0)
    {
        $p = new WordstatQueryModify;
        $p->addToParsing($i);
    }

    public function actionPutTask()
    {
        $job_provider = new WordstatTaskCreator;
        $job_provider->start();
    }

    public function actionSimple(){
        $p = new WordstatParser();
        $p->start();
    }

    public function actionAddSimpleParsing(){
        WordstatParsingTask::getInstance()->addAllKeywordsToParsing();
    }

    private $collection;

    public function actionTest(){
        $mongo = new Mongo('mongodb://localhost');
        $mongo->connect();
        $this->collection = $mongo->selectCollection('parsing', 'simple_parsing');
        echo $this->collection->remove(array('id' => 63312236));
    }
}