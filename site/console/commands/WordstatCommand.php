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

    public function actionAddSimpleParsing()
    {
        WordstatParsingTask::getInstance()->addAllKeywordsToParsing();
    }

    private $collection;

    public function actionTest()
    {
        $mongo = new Mongo('mongodb://localhost');
        $mongo->connect();
        $this->collection = $mongo->selectCollection('parsing', 'simple_parsing');
        echo $this->collection->remove(array('id' => 63312236));
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

    public function actionAddToParsing(){

    }





    public function actionCheckMysqlRelationsSpeed()
    {
        $t = microtime(true);
//        $keywords = Yii::app()->db_keywords->createCommand()
//            ->select('id')
//            ->from('keywords')
//            ->limit(1000)
//            ->queryColumn();

        $list = Yii::app()->db_keywords->createCommand()
            ->select('*')
            ->from('keywords')
            ->where('name="красивые знаменитые мужчины фото"')
            ->limit(1)
            ->queryAll();
//        for ($i = 0; $i < 1000; $i++) {
//            $sql = '';
//            for ($j = $i + 1; $j < 1000; $j++)
//                $sql .= "INSERT INTO keywords__relations values (" . $keywords[$i] . ", " . $keywords[$j] . ");";
//
//            if (!empty($sql))
//                Yii::app()->db_keywords->createCommand($sql)
//                    ->execute();
//        }

        echo microtime(true) - $t;
        echo "\n" . count($list);
    }

    public function actionCheckMongoDbRelationsSpeed()
    {
//        $keywords = Yii::app()->db_keywords->createCommand()
//            ->select('id')
//            ->from('keywords')
//            ->limit(1000)
//            ->queryColumn();

        $mongo = new Mongo(Yii::app()->mongodb_parsing->connectionString);
        $mongo->connect();
        $collection = $mongo->selectCollection('parsing', 'keywords');

        $t = microtime(true);

//        for ($i = 0; $i < 1000; $i++)
//            for ($j = $i + 1; $j < 1000; $j++) {
//                $collection->insert(array(
//                    'keyword_from_id' => (int)$keywords[$i],
//                    'keyword_to_id' => (int)$keywords[$j],
//                ));
//            }

        $rec = $collection->findOne(array('name' => 'красивые знаменитые мужчины фото'));

        echo microtime(true) - $t;
        var_dump($rec);
    }

    public function actionCopyKeywords()
    {
        $mongo = new Mongo(Yii::app()->mongodb_parsing->connectionString);
        $mongo->connect();

        $collection = $mongo->selectCollection('parsing', 'keywords');
        $collection->ensureIndex(array('id' => 1), array("unique" => true));
        $collection->ensureIndex(array('name' => 1), array("unique" => true));
        $collection->ensureIndex(array('wordstat' => -1));


        $dataProvider = new CSqlDataProvider('select * from keywords.keywords', array(
            'totalItemCount' => 10000000,
            'pagination' => array(
                'pageSize' => 10000,
            ),
        ));
        $iterator = new CDataProviderIterator($dataProvider, 10000);

        foreach ($iterator as $keyword) {
            $collection->insert(array(
                'id' => (int)$keyword['id'],
                'name' => $keyword['name'],
                'wordstat' => (int)$keyword['wordstat'],
                'status' => (int)$keyword['status'],
            ));
        }

    }
}