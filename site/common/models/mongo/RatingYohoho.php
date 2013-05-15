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
            'entity_id' => 1,
            'entity_name' => 1,
        ), array('name' => 'entity'));

        $this->getCollection()->ensureIndex(array(
            'entity_id' => 1,
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

    public function findLastDayLikes()
    {
        $from_time = time() - 3600 * 24;
        $cursor = $this->getCollection()->find(array('time > ' . $from_time));
        $list = array();
        while ($cursor->hasNext())
            $list [] = $cursor->getNext();

        return $list;
    }
}
