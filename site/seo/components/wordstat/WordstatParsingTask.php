<?php
/**
 * insert Description
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */

class WordstatParsingTask
{
    /**
     * @var WordstatParsingTask
     */
    protected static $_instance;
    protected $mongo;
    protected $simple_collection;

    private function __construct()
    {
        $this->mongo = new Mongo('mongodb://localhost');
        $this->mongo->connect();
        $this->simple_collection = $this->mongo->selectCollection('parsing', 'simple_parsing');
    }

    private function __clone()
    {
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

    public function addAllKeywordsToParsing()
    {
        $this->simple_collection->ensureIndex(array('id' => 1), array("unique" => true));

        $ids = 1;
        $max_id = 0;
        $i = 0;
        while (!empty($ids)) {
            $ids = Yii::app()->db_keywords->createCommand()
                ->select('id')
                ->from('keywords')
                ->where('id > ' . $max_id)
                ->limit(10000)
                ->order('id')
                ->queryColumn();
            foreach ($ids as $id)
                $this->simple_collection->insert(array('id' => (int)$id));

            if (!empty($ids))
                $max_id = $ids[count($ids) - 1];
            $i++;

            if ($i % 10 == 0)
                echo $max_id . "\n";
        }
    }

    /**
     * Удаляет слово из очереди на простой парсинг
     * @param $id int
     */
    public function removeSimpleTask($id)
    {
        $this->simple_collection->remove(array('id' => (int)$id));
    }

    /**
     * Добавляет слово в очередь на простой парсинг
     * @param $id int
     */
    public function addSimpleTask($id)
    {
        $this->simple_collection->insert(array('id' => (int)$id));
    }
}