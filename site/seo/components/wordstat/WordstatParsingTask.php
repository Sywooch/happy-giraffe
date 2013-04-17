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

    private function __construct()
    {
        $this->mongo = new Mongo('mongodb://localhost');
        $this->mongo->connect();
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
        $collection = $this->mongo->selectCollection('parsing', 'simple_parsing');
        $collection->ensureIndex(array('id' => 1), array("unique" => true));

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
                $collection->insert(array('id' => (int)$id));

            if (!empty($ids))
                $max_id = $ids[count($ids) - 1];
            $i++;

            if ($i % 10 == 0)
                echo $max_id . "\n";
        }
    }
}