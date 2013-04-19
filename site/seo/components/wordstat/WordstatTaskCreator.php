<?php
/**
 * Создает и добавляет задания в очередь
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */

class WordstatTaskCreator
{
    const JOB_LIMIT = 500;

    private $max_id = 0;
    private $client;
    /**
     * @var MongoCollection
     */
    private $collection;

    public function start()
    {
        if (!$this->collection) {
            $mongo = new Mongo('mongodb://localhost');
            $mongo->connect();
            $this->collection = $mongo->selectCollection('parsing', 'simple_parsing');
        }

        $this->client = Yii::app()->gearman->client();
        $this->loadMoreKeywords();

        while (1) {
            sleep(2);

            if ($this->remainCount() < (self::JOB_LIMIT))
                $this->loadMoreKeywords(self::JOB_LIMIT);
        }
    }

    private function remainCount()
    {
        $t1 = microtime(true);
        $count = $this->collection->find(array('id' => array('$lt' => $this->max_id)))->count();
        echo $count . ' ' . (microtime(true) - $t1);

        return $count;
    }

    /**
     * Загрузить ключевых слов на парсинг
     */
    public function loadMoreKeywords()
    {
        echo "add keywords\n";
        $cur = $this->collection->find();
        for ($i = 0; $i < self::JOB_LIMIT; $i++) {
            if ($cur->hasNext()) {
                $keyword = $cur->getNext();
                $this->addTaskToQueue($keyword['id']);
                $this->max_id = $keyword['id'];
            } else {
                echo "application complete successfully\n";
                Yii::app()->end();
            }
        }
    }

    /**
     * Добавляем ключевое слово в очередь
     * @param $keyword_id int
     */
    private function addTaskToQueue($keyword_id)
    {
        $this->client->doBackground("simple_parsing", $keyword_id);
    }
}