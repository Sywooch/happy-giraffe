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

    public function actionSimple()
    {
        $p = new WordstatParser();
        $p->start();
    }

    public function actionDeleteNulls()
    {
        $last_id = 346000000;
        while (true) {
            $condition = 'wordstat = 0 AND id > ' . $last_id;
            $ids = Yii::app()->db_keywords->createCommand()
                ->select('id')
                ->from('keywords')
                ->order('id asc')
                ->where($condition)
                ->limit(10000)
                ->queryColumn();

            foreach ($ids as $id)
                WordstatParsingTask::getInstance()->removeSimpleTask($id);

            $last_id = end($ids);
            echo $last_id . "\n";
            if (empty($ids))
                break;
        }
    }

    public function actionTest()
    {
        $c = new MysqlMongoPerformanceTests;
        //$c->relationsInsertTest();
        $c->relationsFindTest();
        $c->findKeywordByNameTest();
    }

    public function actionCopyKeywords()
    {
        $mongo = new Mongo(Yii::app()->mongodb_parsing->connectionString);
        $mongo->connect();

        $collection = $mongo->selectCollection('parsing', 'keywords');
        $collection->ensureIndex(array('id' => 1), array("unique" => true));
        $collection->ensureIndex(array('name' => 1), array("unique" => true));
        $collection->ensureIndex(array('wordstat' => -1));

        $last_id = 0;
        while (true) {
            $condition = 'id > ' . $last_id;
            $keywords = Yii::app()->db_keywords->createCommand()
                ->select('*')
                ->from('keywords')
                ->order('id asc')
                ->where($condition)
                ->limit(10000)
                ->queryAll();

            foreach ($keywords as $keyword) {
                $last_id = $keyword['id'];
                $collection->insert(array(
                    'id' => (int)$keyword['id'],
                    'name' => $keyword['name'],
                    'wordstat' => (int)$keyword['wordstat'],
                    'status' => (int)$keyword['status'],
                ));
            }

            echo $last_id . "\n";
            if (empty($ids))
                break;
        }
    }

    public function actionAddToTestParsing()
    {
        WordstatParsingTask::getInstance()->addAllKeywordsToParsing();
    }
}