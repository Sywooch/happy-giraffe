<?php

/**
 * Class KeywordDirectRelation
 *
 * Хранения связей из wordstat между ключевыми словами
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class KeywordDirectRelation
{
    public $keyword_from_id;
    public $keyword_to_id;

    /**
     * @var KeywordDirectRelation
     */
    private static $_instance;
    private $collection;

    /**
     * @return KeywordDirectRelation
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
            $mongo = Yii::app()->mongodb_parsing->getConnection();
            $this->collection = $mongo->selectCollection('parsing', 'keywords_direct_relations');
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
        while ($cursor->hasNext())
            $list [] = $cursor->getNext()['keyword_to_id'];

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
     * Сохранение связи "Что искали со словами"
     *
     * @param $keyword_from_id int
     * @param $keyword_to_id int
     */
    public function saveRelation($keyword_from_id, $keyword_to_id)
    {
        //if (!$this->exist($keyword_from_id, $keyword_to_id)) {
            try {
                $this->getCollection()->insert(array(
                    'keyword_from_id' => (int)$keyword_from_id,
                    'keyword_to_id' => (int)$keyword_to_id
                ));
            } catch (Exception $err) {

            }
        //}
    }
}