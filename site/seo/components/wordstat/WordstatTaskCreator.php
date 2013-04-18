<?php
/**
 * Создает и добавляет задания в очередь
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */

class WordstatTaskCreator
{
    const JOB_LIMIT = 500;

    private $jobs = array();
    private $client;
    /**
     * @var MongoCollection
     */
    private $collection;

    public function start()
    {
        $this->client = Yii::app()->gearman->client();
        $this->loadMoreKeywords();

        while (1) {
            sleep(2);

            $t1 = microtime(true);
            foreach ($this->jobs as $key => $job) {
                $stat = $this->client->jobStatus($job[0]);
                if ($stat[0] === false) {
                    //удаляем из отслеживаемых заданий
                    unset($this->jobs[$key]);
                    //удаляем из очереди базы данных
                    $this->collection->remove(array('id' => (int)$job[1]));
                }
            }
            echo (microtime(true) - $t1)."\n";

            if (count($this->jobs) < (self::JOB_LIMIT - 100))
                $this->loadMoreKeywords(100);
        }
    }

    /**
     * Загрузить ключевых слов на парсинг
     */
    public function loadMoreKeywords()
    {
        if (!$this->collection) {
            $mongo = new Mongo('mongodb://localhost');
            $mongo->connect();
            $this->collection = $mongo->selectCollection('parsing', 'simple_parsing');
        }

        $cur = $this->collection->find();
        while (count($this->jobs) < self::JOB_LIMIT && $cur->hasNext()) {
            $keyword = $cur->getNext();
            if (!$this->taskExist($keyword['id']))
                $this->addTaskToQueue($keyword['id']);
        }
    }

    /**
     * Добавляем ключевое слово в очередь
     * @param $keyword_id int
     */
    private function addTaskToQueue($keyword_id)
    {
        $job_handle = $this->client->doBackground("simple_parsing", $keyword_id);
        $this->jobs [] = array($job_handle, $keyword_id);
    }

    /**
     * Добавлено ли ключевое слово в задания
     * @param $keyword_id int
     * @return bool
     */
    private function taskExist($keyword_id)
    {
        foreach ($this->jobs as $job)
            if ($job[1] == $keyword_id)
                return true;
        return false;
    }
}