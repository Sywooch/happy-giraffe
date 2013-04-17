<?php
/**
 * Создает и добавляет задания в очередь
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */

class WordstatTaskCreator
{
    private $jobs = array();
    private $client;
    /**
     * @var MongoCollection
     */
    private $collection;

    public function start()
    {
        $this->loadMoreKeywords();
        $this->client = Yii::app()->gearman->client();

        while (1) {
            sleep(1);
            foreach ($this->jobs as $key => $job) {
                $stat = $this->client->jobStatus($job[0]);
                if ($stat[0] === false) {
                    echo $job[1] . " ended\n";
                    //удаляем из отслеживаемых заданий
                    unset($this->jobs[$key]);
                    //удаляем из очереди базы данных
                    $this->collection->remove(array('id' => $job[1]));
                }
            }

            if (count($this->jobs) < 90)
                $this->loadMoreKeywords(10);
        }
    }

    /**
     * Загрузить ключевых слов на парсинг
     * @param int $count кол-во ключевых слов
     */
    public function loadMoreKeywords($count = 100)
    {
        if (!$this->collection) {
            $mongo = new Mongo('mongodb://localhost');
            $mongo->connect();
            $this->collection = $mongo->selectCollection('parsing', 'simple_parsing');
        }

        echo "adding keyword to queue\n";

        $cur = $this->collection->find();
        for ($i = 0; $i < $count; $i++) {
            $keyword = $cur->getNext();
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
}