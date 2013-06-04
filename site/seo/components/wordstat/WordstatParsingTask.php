<?php
/**
 * Компонент простых заданий на парсинг. Через него можно добавлять и удалять задания на простой парсинг.
 * Реализован через паттерн singleton
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class WordstatParsingTask
{
    /**
     * @var WordstatParsingTask
     */
    protected static $_instance;
    /**
     * @var Mongo
     */
    protected $mongo;
    /**
     * очередь на парсинг частоты "!слово !слово"
     * @var MongoCollection[]
     */
    protected $collections;

    private function __construct()
    {
        $this->mongo = Yii::app()->mongodb_parsing->getConnection();
    }

    /**
     * @param $queue
     * @return MongoCollection
     */
    private function getCollection($queue)
    {
        if (!isset($this->collections[$queue])) {
            $this->collections[$queue] = $this->mongo->selectCollection('parsing', $queue);
            $this->collections[$queue]->ensureIndex(array('id' => 1), array("unique" => true));
        }
        return $this->collections[$queue];
    }

    /**
     * @return WordstatParsingTask
     */
    public static function getInstance()
    {
        if (null === self::$_instance)
            self::$_instance = new self();
        return self::$_instance;
    }

    /**
     * Добавить все ключевые слова на парсинг
     */
    public function addAllKeywordsToSeasonParsing()
    {
        $ids = 1;
        $max_id = 0;
        $i = 0;
        while (!empty($ids)) {
            $ids = Yii::app()->db_keywords->createCommand()
                ->select('id')
                ->from('keywords')
                ->where('wordstat >= 100 AND wordstat < 1000 AND id > ' . $max_id)
                ->limit(10000)
                ->order('id')
                ->queryColumn();
            foreach ($ids as $id)
                $this->getCollection('season_parsing')->insert(array('id' => (int)$id));

            if (!empty($ids))
                $max_id = $ids[count($ids) - 1];
            $i++;

            if ($i % 10 == 0)
                echo $max_id . "\n";
        }
    }

    /**
     * Удаляет слово из очереди на простой парсинг
     * @param $id int ID ключевого слова
     * @param $queue string название очереди
     */
    public function removeSimpleTask($id, $queue = 'simple_parsing')
    {
        $this->getCollection($queue)->remove(array('id' => (int)$id));
    }

    /**
     * Добавляет слово в очередь на простой парсинг
     * @param $id int ID ключевого слова
     * @param $queue string название очереди
     */
    public function addSimpleTask($id, $queue = 'simple_parsing')
    {
        if ($this->getCollection($queue)->findOne(array('id' => (int)$id)) === null)
            $this->getCollection($queue)->insert(array('id' => (int)$id));
    }
}