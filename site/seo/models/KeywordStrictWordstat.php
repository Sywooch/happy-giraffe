<?php

/**
 * Class KeywordStrictWordstat
 *
 * Хранения частоты "!wordstat"
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class KeywordStrictWordstat
{
    public $id;
    public $value;

    /**
     * @var KeywordDirectRelation
     */
    private static $_instance;
    private $collection;

    /**
     * @return KeywordStrictWordstat
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
            $this->collection = $mongo->selectCollection('parsing', 'keywords_strict_wordstat');
            $this->collection->ensureIndex(array('id' => 1), array("unique" => true));
        }

        return $this->collection;
    }

    /**
     * Возвращает частоту "!wordstat"
     * @param int $id id кейворда
     * @return int значение
     */
    public function getValue($id)
    {
        $model = $this->getCollection()->findOne(array('id' => (int)$id));
        if ($model === null)
            return -1;
        return $model['value'];
    }

    /**
     * Сохранение частоты "!wordstat"
     *
     * @param int $id id кейворда
     * @param int $value значение
     * @return bool
     */
    public function save($id, $value)
    {
        $model = $this->getCollection()->findOne(array('id' => (int)$id));
        if ($model === null)
            $this->getCollection()->insert(array('id' => (int)$id, 'value' => (int)$value));
        else
            $this->getCollection()->update(array('_id' => $model['_id']), array('value' => (int)$value));
    }
}