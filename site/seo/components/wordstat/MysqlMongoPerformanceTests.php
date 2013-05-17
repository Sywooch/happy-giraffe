<?php
/**
 * Тесты производительности Mysql и MongoDb
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */

class MysqlMongoPerformanceTests
{
    /**
     *
     */
    public function relationsInsertTest()
    {
        $t = microtime(true);
        $keywords = Yii::app()->db_keywords->createCommand()
            ->select('id')
            ->from('keywords')
            ->limit(1000)
            ->queryColumn();

        for ($i = 0; $i < 1000; $i++) {
            $sql = '';
            for ($j = $i + 1; $j < 1000; $j++)
                $sql .= "INSERT INTO keywords__relations values (" . $keywords[$i] . ", " . $keywords[$j] . ");";

            if (!empty($sql))
                Yii::app()->db_keywords->createCommand($sql)->execute();
        }

        echo 'mysql: ' . (microtime(true) - $t) . "\n";

        $mongo = new Mongo(Yii::app()->mongodb_parsing->connectionString);
        $mongo->connect();
        $collection = $mongo->selectCollection('parsing', 'keywords_relations');

        $t = microtime(true);

        for ($i = 0; $i < 1000; $i++)
            for ($j = $i + 1; $j < 1000; $j++) {
                $collection->insert(array(
                    'keyword_from_id' => (int)$keywords[$i],
                    'keyword_to_id' => (int)$keywords[$j],
                ));
            }

        echo 'mongodb: ' . (microtime(true) - $t) . "\n";
    }

    /**
     *
     */
    public function relationsFindTest()
    {
        $keyword_id = 67332768;

        $t = microtime(true);
        $list = Yii::app()->db_keywords->createCommand()
            ->select('keyword_to_id')
            ->from('keywords__relations')
            ->where('keyword_from_id=' . $keyword_id)
            ->queryColumn();

        echo 'mysql: ' . (microtime(true) - $t) . "\n";
        echo count($list) . "\n";

        $mongo = new Mongo(Yii::app()->mongodb_parsing->connectionString);
        $mongo->connect();
        $collection = $mongo->selectCollection('parsing', 'keywords_indirect_relations');
        $collection->ensureIndex(array('keyword_from_id' => 1));
        $collection->ensureIndex(array('keyword_from_id' => 1, 'keyword_to_id' => 1), array("unique" => true));
        $cursor = $collection->find(array('keyword_from_id' => $keyword_id));
        $list = array();

        $t = microtime(true);
        while ($cursor->hasNext())
            $list [] = $cursor->getNext();

        echo 'mongodb: ' . (microtime(true) - $t) . "\n";
        echo count($list) . "\n";
    }

    /**
     *
     */
    public function findKeywordByNameTest()
    {
        $name = "как зарабатывать деньги дома";
        $t = microtime(true);
        $list = Yii::app()->db_keywords->createCommand()
            ->select('*')
            ->from('keywords')
            ->where('name="'.$name.'"')
            ->limit(1)
            ->queryAll();

        echo 'mysql: ' . (microtime(true) - $t) . "\n";
        echo count($list) . "\n";

        $mongo = new Mongo(Yii::app()->mongodb_parsing->connectionString);
        $mongo->connect();
        $collection = $mongo->selectCollection('parsing', 'keywords');

        $t = microtime(true);
        $list = $collection->findOne(array('name' => $name));

        echo 'mongodb: ' . (microtime(true) - $t) . "\n";
        echo count($list) . "\n";
    }
}