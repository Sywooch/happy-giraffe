<?php
/**
 * Создает и добавляет задания в очередь. Вытаскивает задания из таблицы отсортированные по ID, порциями,
 * начиная с меньшего, запоминает max_id, чтобы следующую порцию вытаскивать > max_id
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class WordstatTaskCreator
{
    const JOB_LIMIT = 5000;

    /**
     * @var int ID последнего выданного задания
     */
    private $max_id = 0;
    /**
     * @var GearmanClient
     */
    private $client;
    /**
     * @var MongoCollection
     */
    private $collection;

    /**
     * Запуск передачи заданий из базы данных в очередь
     */
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

    /**
     * Возвращает кол-во заданий, которые были выданы но еще не выполнены (не удалены из бд)
     * @return int кол-во невыполненных заданий
     */
    private function remainCount()
    {
        return $this->collection->find(array('id' => array('$lt' => $this->max_id)))->count();
    }

    /**
     * Загрузить ключевых слов на парсинг
     */
    public function loadMoreKeywords()
    {
        echo "add keywords\n";
        $cur = $this->collection->find(array('id' => array('$gt' => $this->max_id)))->sort(array('id' => 1));
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

        echo 'max_id: '.$this->max_id."\n";
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