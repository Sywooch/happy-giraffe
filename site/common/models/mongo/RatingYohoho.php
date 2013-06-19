<?php
/**
 * Class RatingYohoho
 *
 * Хранение лайков
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class RatingYohoho extends HMongoModel
{
    /**
     * @var RatingYohoho
     */
    private static $_instance;
    protected $_collection_name = 'ratings_yohoho';

    public $entity_id;
    public $entity_name;
    public $user_id;
    public $created;

    /**
     * @return RatingYohoho
     */
    public static function model()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    private function __construct()
    {
    }

    public function ensureIndexes()
    {
        $this->getCollection()->ensureIndex(array(
            'entity_id' => -1,
            'entity_name' => 1,
        ), array('name' => 'entity'));

        $this->getCollection()->ensureIndex(array(
            'entity_id' => -1,
            'entity_name' => 1,
            'user_id' => 1,
        ), array('name' => 'user_entity'));

        $this->getCollection()->ensureIndex(array(
            'time' => -1,
        ), array('name' => 'time'));
    }

    /**
     * Поиск лайка текущего пользователя
     *
     * @param $entity
     * @return RatingYohoho
     */
    public function findByEntity($entity)
    {
        $entity_id = (int)$entity->primaryKey;
        $entity_name = get_class($entity);

        $like = $this->getCollection()->findOne(array(
            'entity_id' => $entity_id,
            'entity_name' => $entity_name,
            'user_id' => (int)Yii::app()->user->id,
        ));

        return self::createModel($like);
    }

    /**
     * Кол-во лайков статьи
     *
     * @param $entity
     * @return int
     */
    public function countByEntity($entity)
    {
        $entity_id = (int)$entity->primaryKey;
        $entity_name = get_class($entity);

        return $this->getCollection()->count(array(
            'entity_id' => $entity_id,
            'entity_name' => $entity_name,
        ));
    }

    /**
     * Схранение лайка текущего пользователя
     *
     * @param $entity
     * @return bool
     */
    public function saveByEntity($entity)
    {
        $model = $this->findByEntity($entity);
        if ($model)
            $model->delete();
        else {
            $this->create($entity);
            return true;
        }
        return false;
    }

    /**
     * Создание лайка в бд
     * @param $entity
     * @return RatingYohoho
     */
    public function create($entity)
    {
        $this->ensureIndexes();

        $entity_id = (int)$entity->primaryKey;
        $entity_name = get_class($entity);

        $this->getCollection()->insert(array(
            'entity_id' => $entity_id,
            'entity_name' => $entity_name,
            'user_id' => (int)Yii::app()->user->id,
            'time' => time(),
        ));
    }

    /**
     * Создает модель уведомления для удобой работы с ним
     *
     * @param $object array объект, который вернул компонент работы с базой
     * @return NotificationDiscussContinue
     */
    public static function createModel($object)
    {
        if (empty($object))
            return null;

        $model = new RatingYohoho;
        foreach ($object as $key => $value)
            $model->$key = $value;

        return $model;
    }

    /**
     * Возвращает все лайки за последние сутки
     * @return array
     */
    public function findLastDayLikes()
    {
        $from_time = time() - 3600 * 24;
        $cursor = $this->getCollection()->find(array('time' => array('$gt' => $from_time)));
        $list = array();
        while ($cursor->hasNext())
            $list [] = $cursor->getNext();

        return $list;
    }

    /**
     * Кол-во лайков за промежуток времени
     *
     * @param string $time1
     * @param string $time2
     * @return int
     */
    public function DateLikes($time1, $time2)
    {
        return $this->getCollection()->count(array(
            'time' => array('$gte' => strtotime($time1), '$lte' => strtotime($time2))
        ));
    }
}
