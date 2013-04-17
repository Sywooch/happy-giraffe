<?php
/**
 * Создает и добавляет задания в очередь
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */

class WordstatTaskCreator
{
    private $jobs = array();
    private $keywords = array();
    /**
     * @var MongoCollection
     */
    private $collection;

    public function start()
    {
        $this->loadMoreKeywords();
        $client = Yii::app()->gearman->client();

        for ($i = 0; $i < 20; $i++) {
            $text = 'task.' . $i;
            $job_handle = $client->doBackground("simple_parsing", serialize($text));
            if ($client->returnCode() != GEARMAN_SUCCESS) {
                echo 'send task fail';
                Yii::app()->end();
            }
            $this->jobs [] = array($job_handle, $i);
        }

        while (1) {
            sleep(1);
            foreach ($this->jobs as $key => $job) {
                $stat = $client->jobStatus($job[0]);
                if ($stat[0] === false) {
                    echo $job[1] . " ended\n";
                    unset($this->jobs[$key]);
                    $this->collection->remove(array('id' => $job[1]));
                }
            }
        }
    }

    public function loadMoreKeywords($count = 10000)
    {
        if (!$this->collection) {
            $m = new Mongo('mongodb://localhost');
            $m->connect();
            $this->collection = $m->selectCollection('parsing', 'simple_parsing');
        }
        for ($i = 0; $i < 1000000; $i++) {
            $this->collection->remove(array('id' => $i));
        }
    }

    public function addKeywordsToParsing()
    {
        if (!$this->collection) {
            $m = new Mongo('mongodb://localhost');
            $m->connect();
            $this->collection = $m->selectCollection('parsing', 'simple_parsing');
            $this->collection->ensureIndex(array('id' => 1), array("unique" => true));
        }

        $criteria = new CDbCriteria;
        $criteria->limit = 100;
        $criteria->offset = 0;

        $ids = 1;
        $max_id = 0;
        $i=0;
        while (!empty($ids)) {
            $ids = Yii::app()->db_keywords->createCommand()
                ->select('id')
                ->from('keywords')
                ->where('id > ' . $max_id)
                ->limit(10000)
                ->order('id')
                ->queryColumn();
            foreach ($ids as $id)
                $this->collection->insert(array('id' => $id));

            if (!empty($ids))
                $max_id = $ids[count($ids) - 1];
            $i++;

            if ($i % 10 == 0)
                echo $i."\n";
        }
    }
}