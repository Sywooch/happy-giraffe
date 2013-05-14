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
     * Основной парсинг частоты
     * @var MongoCollection
     */
    protected $simple_collection;
    /**
     * @var MongoCollection
     */
    protected $priority_collection;
    /**
     * очередь на парсинг частоты "!слово !слово"
     * @var MongoCollection
     */
    protected $strict_collection;

    private function __construct()
    {
        $this->mongo = new Mongo(Yii::app()->mongodb_parsing->connectionString);
        $this->mongo->connect();
    }

    /**
     * @return MongoCollection
     */
    private function getSimpleCollection()
    {
        if ($this->simple_collection === null){
            $this->simple_collection = $this->mongo->selectCollection('parsing', 'simple_parsing');
            $this->simple_collection->ensureIndex(array('id' => 1), array("unique" => true));
        }
        return $this->simple_collection;
    }

    /**
     * @return MongoCollection
     */
    private function getStrictCollection()
    {
        if ($this->strict_collection === null){
            $this->strict_collection = $this->mongo->selectCollection('parsing', 'strict_parsing');
            $this->strict_collection->ensureIndex(array('id' => 1), array("unique" => true));
        }
        return $this->strict_collection;
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
    public function addAllKeywordsToParsing()
    {
        $ids = 1;
        $max_id = 0;
        $i = 0;
        while (!empty($ids)) {
            $ids = Yii::app()->db_keywords->createCommand()
                ->select('id')
                ->from('keywords')
                ->where('status is null AND id > ' . $max_id)
                ->limit(10000)
                ->order('id')
                ->queryColumn();
            foreach ($ids as $id)
                $this->getSimpleCollection()->insert(array('id' => (int)$id));

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
     */
    public function removeSimpleTask($id)
    {
        $this->simple_collection->remove(array('id' => (int)$id));
    }

    /**
     * Добавляет слово в очередь на простой парсинг
     * @param $id int ID ключевого слова
     */
    public function addSimpleTask($id)
    {
        $this->simple_collection->insert(array('id' => (int)$id));
    }

    /**
     * Добавляет слово в очередь на парсинг по строгому соответствию
     * @param $id int ID ключевого слова
     */
    public function addStrictTask($id)
    {
        $this->getStrictCollection()->insert(array('id' => (int)$id));
    }

    /**
     * Удаляет слово из очереди на парсинг по строгому соответствию
     * @param $id int ID ключевого слова
     */
    public function removeStrictTask($id)
    {
        $this->getStrictCollection()->remove(array('id' => (int)$id));
    }


    /**
     * Добавляет слово в очередь очень срочных заданий
     * @param $id int ID ключевого слова
     */
    public function addImportantTask($id)
    {
        $this->priority_collection->insert(array('id' => (int)$id));
    }
}