<?php

/**
 * Class HGLike
 *
 * Хранение лайков
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class HGLike extends HMongoModel
{

    public $isNewRecord = false;

    public function attributeNames()
    {
        return array();
    }

    /**
     * @var HGLike
     */
    private static $_instance;
    protected $_collection_name = 'ratings_yohoho';

    /**
     * @var int id модели которую лайкнули
     */
    public $entity_id;

    /**
     * @var string class модели которую лайкнули
     */
    public $entity_name;

    /**
     * @var int id пользователя, который поставил лайк
     */
    public $user_id;

    /**
     * @var int время проставления лайка
     */
    public $time;

    /**
     * @return HGLike
     */
    public static function model()
    {
        if (null === self::$_instance)
        {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function behaviors()
    {
        return array(
            'notificationBehavior' => array(
                'class' => 'site\frontend\modules\notifications\behaviors\LikeBehavior',
            ),
        );
    }

    protected function __construct()
    {
        $this->init();
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
     * @return HGLike
     */
    public function findByEntity($entity)
    {
        $entity_id = (int) $entity->primaryKey;
        $entity_name = get_class($entity);

        $like = $this->getCollection()->findOne(array(
            'entity_id' => $entity_id,
            'entity_name' => $entity_name,
            'user_id' => (int) Yii::app()->user->id,
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
        if (method_exists($entity, 'getIsFromBlog'))
        {
            if ($entity->getIsFromBlog())
                $entity_name = 'BlogContent';
            else
                $entity_name = 'CommunityContent';
        }
        else
            $entity_name = get_class($entity);
        $entity_id = (int) $entity->primaryKey;

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
        {
            $model->delete();
            PostRating::reCalc($entity);
            return false;
        }
        $this->create($entity);
        PostRating::reCalc($entity);
        return true;
    }

    /**
     * Создание лайка в бд
     * @param $entity
     * @return HGLike
     */
    public function create($entity)
    {
        $this->ensureIndexes();

        $entity_id = (int) $entity->primaryKey;
        $entity_name = get_class($entity);

        $this->getCollection()->insert(array(
            'entity_id' => $entity_id,
            'entity_name' => $entity_name,
            'user_id' => (int) Yii::app()->user->id,
            'time' => time(),
        ));
        ScoreAchievement::model()->checkAchieve(Yii::app()->user->id, ScoreAchievement::TYPE_YOHOHO);

        $like = $this->findByAttributes(array(
            'entity_id' => $entity_id,
            'entity_name' => $entity_name,
            'user_id' => (int) Yii::app()->user->id,
        ));

        $like->isNewRecord = true;
        $like->afterSave();
        $like->isNewRecord = false;
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

        $model = new HGLike;
        foreach ($object as $key => $value)
            $model->$key = $value;

        return $model;
    }

    /**
     * Возвращает все лайки за последние сутки
     * @return array
     */
    private function findLastDayLikes()
    {
        $from_time = time() - 3600 * 24;
        $cursor = $this->getCollection()->find(array('time' => array('$gt' => $from_time)));
        $list = array();
        while ($cursor->hasNext())
            $list [] = $cursor->getNext();

        return $list;
    }

    /**
     * Возвращает количество лайков, которые поставил пользователь
     *
     * @param int $user_id
     * @return int
     */
    public function countByUser($user_id)
    {
        return $this->getCollection()->count(array(
                'user_id' => (int) $user_id,
        ));
    }

    /**
     * Возвращает статьи массив авторов статей с кол-вом лайков
     * array[author_id][entity_name][entity_id] likes count
     * @return array
     */
    public function findLastDayAuthorContentLikes()
    {
        $result = array();
        $likes = HGLike::model()->findLastDayLikes();

        foreach ($likes as $like)
        {
            $model = CActiveRecord::model($like['entity_name'])->findByPk($like['entity_id']);
            if ($model === null)
                continue;
            if ($like['entity_name'] == 'Comment')
                continue;

            if (!isset($result[$model->author_id]))
                $result[$model->author_id] = array();
            if (!isset($result[$model->author_id][$like['entity_name']]))
                $result[$model->author_id][$like['entity_name']] = array();
            if (!isset($result[$model->author_id][$like['entity_name']][$like['entity_id']]))
                $result[$model->author_id][$like['entity_name']][$like['entity_id']] = 0;

            $result[$model->author_id][$like['entity_name']][$like['entity_id']]++;
        }

        return $result;
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

    /**
     * Лайкал ли пользователь запись
     *
     * @param CommunityContent|Comment $entity
     * @param int $user_id
     * @return bool
     */
    public function hasLike($entity, $user_id)
    {
        if (method_exists($entity, 'getIsFromBlog'))
        {
            if ($entity->getIsFromBlog())
                $entity_name = 'BlogContent';
            else
                $entity_name = 'CommunityContent';
        }
        else
            $entity_name = get_class($entity);
        $entity_id = (int) $entity->primaryKey;

        return $this->getCollection()->findOne(array(
                'entity_id' => $entity_id,
                'entity_name' => $entity_name,
                'user_id' => (int) $user_id,
            )) !== null;
    }

    /**
     * @param $model CommunityContent
     */
    public function Fix($model)
    {
        if ($model->getIsFromBlog())
        {
            $this->getCollection()->update(array(
                'entity_id' => (int) $model->id,
                'entity_name' => 'CommunityContent',
                ), array('$set' => array('entity_name' => 'BlogContent')));
        }
    }

    public function findAllByEntity($entity)
    {
        $entity_id = (int) $entity->primaryKey;
        $entity_name = get_class($entity);

        $cursor = $this->getCollection()->find(array(
            'entity_id' => $entity_id,
            'entity_name' => $entity_name,
        ));

        $list = array();
        while ($cursor->hasNext())
            $list[] = $cursor->getNext();
        return $list;
    }

    public function findByAttributes($attributes)
    {
        $obj = null;
        $cursor = $this->getCollection()->find($attributes);
        if ($cursor->hasNext())
            $obj = self::createModel($cursor->getNext());
        return $obj;
    }

    public function findAllByAttributes($attributes)
    {
        $objs = array();
        $cursor = $this->getCollection()->find($attributes);
        while ($cursor->hasNext())
            $objs[] = self::createModel($cursor->getNext());
        return $objs;
    }

}
