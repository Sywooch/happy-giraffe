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

    public function actionCopyStrictWordstat()
    {
        $i = 0;
        do {
            $rows = Yii::app()->db_keywords->createCommand()
                ->select('*')
                ->from('keywords_strict_wordstat')
                ->offset($i * 10000)
                ->limit(10000)
                ->queryAll();
            foreach ($rows as $row) {
                if ($row['strict_wordstat'] == 0) {
                    $this->saveStatus($row['keyword_id']);
                } else {
                    $wordstat = Yii::app()->db_keywords->createCommand()
                        ->select('wordstat')
                        ->from('keywords')
                        ->where('id=' . $row['keyword_id'])
                        ->queryScalar();

                    if (!empty($wordstat)) {
                        if ($wordstat < 1000000 && ($wordstat / $row['strict_wordstat']) > 1000)
                            $this->saveStatus($row['keyword_id']);
                        if ($wordstat >= 1000000 && ($wordstat / $row['strict_wordstat']) > 10000)
                            $this->saveStatus($row['keyword_id']);
                    }
                }
            }

            $i++;
            echo $i."\n";
        } while (!empty($rows));
    }

    private function saveStatus($keyword_id, $status = Keyword::STATUS_BAD_STRICT_WORDSTAT)
    {
        Yii::app()->db_keywords->createCommand()->update('keywords', array('status'=>$status), 'id='.$keyword_id);
    }
}