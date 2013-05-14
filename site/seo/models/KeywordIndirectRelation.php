<?php

/**
 * Class KeywordIndirectRelation
 *
 * Хранения связей из wordstat между ключевыми словами
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class KeywordIndirectRelation
{
    public $keyword_from_id;
    public $keyword_to_id;

    /**
     * @var KeywordIndirectRelation
     */
    private static $_instance;
    private $collection;

    /**
     * @return KeywordIndirectRelation
     */
    public static function getInstance()
    {
        if (null === self::$_instance)
            self::$_instance = new self();
        return self::$_instance;
    }

    private function __construct()
    {
    }

    /**
     * @return MongoCollection
     */
    public function getCollection()
    {
        if ($this->collection === null) {
            $mongo = new Mongo(Yii::app()->mongodb_parsing->connectionString);
            $mongo->connect();
            $this->collection = $mongo->selectCollection('parsing', 'keywords_indirect_relations');
            $this->collection->ensureIndex(array('keyword_from_id' => 1));
            $this->collection->ensureIndex(array('keyword_from_id' => 1, 'keyword_to_id' => 1), array("unique" => true));
        }

        return $this->collection;
    }

    /**
     * Возвращает массив id всех связанных ключевых слов
     * @return array
     */
    public function getAllRelatedKeywords()
    {
        $cursor = $this->getCollection()->find(array());
        $list = array();
        while ($cursor->hasNext()){
            $row = $cursor->getNext();
            $list [] = $row['keyword_to_id'];
        }

        return $list;
    }

    /**
     * Проверка существует ли такая связь
     *
     * @param $keyword_from_id
     * @param $keyword_to_id
     * @return bool
     */
    public function exist($keyword_from_id, $keyword_to_id)
    {
        $exist = $this->getCollection()->findOne(array(
            'keyword_from_id' => (int)$keyword_from_id,
            'keyword_to_id' => (int)$keyword_to_id
        ));

        return !empty($exist);
    }

    /**
     * Сохранение связи "Что еще искали искавшие"
     *
     * @param $keyword_from_id int
     * @param $keyword_to_id int
     */
    public function saveRelation($keyword_from_id, $keyword_to_id)
    {
        try {
            $this->getCollection()->insert(array(
                'keyword_from_id' => (int)$keyword_from_id,
                'keyword_to_id' => (int)$keyword_to_id
            ));
        } catch (Exception $err) {
            echo $err->getMessage();
            Yii::app()->end();
        }
    }
}