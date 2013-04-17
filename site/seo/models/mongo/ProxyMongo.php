<?php
/**
 * Class ProxyMongo
 *
 * Класс для работы с прокси через mongo-базу
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class ProxyMongo extends EMongoDocument
{
    /**
     * @var string сам прокси
     */
    public $value;
    /**
     * @var int занят ли прокси
     */
    public $active = 0;
    /**
     * @var int показатель качества прокси
     */
    public $rank;
    /**
     * @var int время в секундах добавления прокси в базу
     */
    public $created;

    public function getCollectionName()
    {
        return 'proxy';
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function indexes()
    {
        return array(
            'index_rank' => array(
                'key' => array(
                    'rank' => EMongoCriteria::SORT_DESC
                ),
            ),
        );
    }

    public function beforeSave()
    {
        if ($this->isNewRecord)
            $this->created = time();
        $this->rank = (int)$this->rank;

        return true;
    }

    public function findAndModify($param = array())
    {
        if (!array_key_exists('update', $param) AND !array_key_exists('remove', $param)) //one is required
        {
            return false;
        }

        $collection['findAndModify'] = $this->getCollectionName();
        $param = array_merge($collection, $param);

        $result = $this->getDb()->command($param);
        $result["lastErrorObject"]["ok"] == 1 ? $return = $result["value"] : $return = false;
        return $return;
    }
}