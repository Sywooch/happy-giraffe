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

    /**
     * Соединение с базой данных
     * @return EMongoDB
     */
    public function getMongoDBComponent()
    {
        return Yii::app()->getComponent('mongodb_parsing');
    }

    /**
     * @param string $className
     * @return ProxyMongo
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function indexes()
    {
        return array(
            'index_rank' => array(
                'key' => array(
                    'rank' => EMongoCriteria::SORT_DESC,
                ),
            ),
            'index_value' => array(
                'key' => array(
                    'value' => EMongoCriteria::SORT_DESC,
                ),
            ),
            'index_active' => array(
                'key' => array(
                    'active' => EMongoCriteria::SORT_DESC,
                ),
            ),
        );
    }

    public function beforeSave()
    {
        if ($this->isNewRecord) {
            $this->created = time();
            $this->rank = 10;
        } else
            $this->rank = (int)$this->rank;

        return true;
    }

    /**
     * Возвращает массив с лучшей прокси и одновременно меняет ее на активную
     * @return array
     */
    public function getProxy()
    {
        return $this->getCollection()->findAndModify(
            array("active" => 0),
            array('$set' => array('active' => 1)),
            null,
            array(
                "sort" => array("rank" => EMongoCriteria::SORT_DESC),
            )
        );
    }

    /**
     * Добавить новый прокси в базу
     * @param $value новый прокси
     */
    public function addNewProxy($value)
    {
        foreach ($this->indexes() as $index_name => $index)
            $this->getCollection()->ensureIndex($index['key'], array('name' => $index_name));

        $value = trim($value);
        $exist = $this->getCollection()->findOne(array('value' => $value));
        if (!$exist) {
            $this->getCollection()->insert(array(
                'value' => $value,
                'rank' => 10,
                'active' => 0,
                'created' => time(),
            ));
        }
    }

    /**
     * Удалить лишние прокси чтобы кол-во не превышало 40,000
     */
    public function removeExtra()
    {
        while (ProxyMongo::model()->count() > 40000) {
            $criteria = new EMongoCriteria();
            $criteria->addCond('active', '==', 0);
            $criteria->setSort(array('rank' => EMongoCriteria::SORT_ASC));
            $criteria->setLimit(1000);

            $models = ProxyMongo::model()->findAll($criteria);
            foreach ($models as $model)
                $model->delete();
        }
    }

    /**
     * Обновление рейтинга прокси и изменение ее статуса на неактивную
     * @param $proxy array прокси
     * @param $newRank int новый рейтинг
     */
    public function updateProxyRank($proxy, $newRank)
    {
        $new_data = array(
            '$set' => array(
                "rank" => (int)$newRank,
                "active" => 0,
            ),
        );
        $this->getCollection()->update(array("_id" => $proxy['_id']), $new_data);
    }
}