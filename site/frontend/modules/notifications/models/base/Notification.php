<?php
/**
 * Class Notification
 *
 * Уведомление пользователю
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class Notification extends HMongoModel
{
    /**
     * @var Notification
     */
    private static $_instance;
    private $_relatedModel = null;
    protected $_collection_name = 'notifications_new';
    
    public function attributeNames()
    {
        return array(
            "type",
            "entity",
            "entity_id",
            //"unread_model_ids",
            //"read_model_ids",
            "updated",
            //"recipient_id",
            //"read",
            "count",
            "relatedModel"
        );
    }

    const USER_CONTENT_COMMENT = 0;
    const REPLY_COMMENT = 1;
    const DISCUSS_CONTINUE = 2;
    const NEW_LIKE = 5;
    const NEW_FAVOURITE = 6;
    const NEW_REPOST = 7;

    const PAGE_SIZE = 20;

    public $type;
    public $updated;
    public $recipient_id;
    public $read = 0;
    public $count = 1;

    protected function __construct()
    {
    }

    protected function __clone()
    {
    }
    
    public function getRelatedModel()
    {
        if(is_null($this->_relatedModel))
        {
            $this->_relatedModel = CActiveRecord::model($this->entity)->findByPk($this->entity_id);
        }
        return $this->_relatedModel;
    }

    /**
     * @return Notification
     */
    public static function model()
    {
        if (null === self::$_instance)
            self::$_instance = new self();
        return self::$_instance;
    }

    public function getId()
    {
        return $this->_id;
    }

    /**
     * Добавляет индекс если не создан
     */
    public function ensureIndex()
    {
        $this->getCollection()->ensureIndex(array(
            'updated' => EMongoCriteria::SORT_DESC,
            'recipient_id' => EMongoCriteria::SORT_DESC,
            'read' => EMongoCriteria::SORT_DESC,
        ), array('name' => 'list_index'));

        $this->getCollection()->ensureIndex(array(
            'type' => EMongoCriteria::SORT_DESC,
            'recipient_id' => EMongoCriteria::SORT_DESC,
            'entity' => EMongoCriteria::SORT_DESC,
            'entity_id' => EMongoCriteria::SORT_DESC,
            'read' => EMongoCriteria::SORT_DESC,
        ), array('name' => 'find_one_index'));

        $this->getCollection()->ensureIndex(array(
            'recipient_id' => EMongoCriteria::SORT_DESC,
            'read' => EMongoCriteria::SORT_DESC,
        ), array('name' => 'count_index'));
    }

    protected function sendSignal($count = 1)
    {
        $comet = new CometModel;
        $comet->send($this->recipient_id, array('count' => $count), CometModel::TYPE_NEW_NOTIFICATION);
    }

    /**
     * Пометить уведомление как прочитанное по id
     * @param $id
     */
    public function readByPk($id)
    {
        $this->getCollection()->update(
            array("_id" => $id),
            array('$set' => array("read" => 1, "read_time" => time()))
        );
    }

    /**
     * Пометить уведомление как Непрочитанное по id
     * @param $id
     */
    public function unreadByPk($id)
    {
        $this->getCollection()->update(
            array("_id" => $id),
            array(
                '$set' => array("read" => 0),
                '$unset' => array("read_time" => 1),
            )
        );
    }

    /**
     * Пометить уведомление как прочитанное
     */
    public function setRead()
    {
        $this->getCollection()->update(
            array("_id" => $this->_id),
            array('$set' => array("read" => 1, "read_time" => time()))
        );
    }

    /**
     * Отметить все как прочитанные
     */
    public function readAll()
    {
        $this->getCollection()->update(
            array(
                "recipient_id" => (int)Yii::app()->user->id,
                'read' => 0
            ),
            array('$set' => array("read" => 1, "read_time" => time())),
            array('multiple' => true)
        );
    }

    /**
     * Создаение нового уведомления
     *
     * @param $specific_fields array массив специфических полей уведомления
     * @param int $count
     */
    protected function insert($specific_fields, $count = 1)
    {
        $this->getCollection()->insert(
            array_merge(array(
                'type' => (int)$this->type,
                'recipient_id' => (int)$this->recipient_id,
                'read' => 0,
                'count' => $count,
                'updated' => time(),
            ), $specific_fields)
        );

        $this->sendSignal($count);
    }

    /**
     * Возвращает количество непрочитанных уведомлений пользователя
     *
     * @param $user_id int id пользователя
     * @return int
     */
    public function getUnreadCount($user_id = null)
    {
        if (empty($user_id))
            $user_id = Yii::app()->user->id;

        return $this->getCollection()->count(array("recipient_id" => (int)$user_id, "read" => 0));
    }

    /**
     * Возвращает список уведомлений для вывода пользователю
     *
     * @param $user_id int id пользователя
     * @param int $read
     * @param $page int номер страницы с уведомлениями
     * @param $withRelated bool Если true, то жадно загружает связанные модели из mysql
     * @return Notification[]
     */
    public function getNotificationsList($user_id, $read = 0, $page = 0, $withRelated = false)
    {
        $cursor = $this->getCollection()->find(array(
            'recipient_id' => (int)$user_id,
            'read' => $read
        ))->sort(array('updated' => -1))->limit(self::PAGE_SIZE)->skip($page * self::PAGE_SIZE);

        
        $list = array();
        $related = array();
        for ($i = 0; $i < self::PAGE_SIZE; $i++) {
            if ($cursor->hasNext()) {
                $list[$i] = self::createNotification($cursor->getNext());
                if($withRelated)
                {
                    $related[$list[$i]->entity][$list[$i]->entity_id] = $i;
                }
            }
        }
        foreach ($related as $class => $value)
        {
            $ids = array_keys($value);
            $models = CActiveRecord::model($class)->findAllByAttributes(array('id' => $ids));
            foreach ($models as $model)
            {
                $index = $related[$class][$model->id];
                $list[$index]->_relatedModel = $model;
            }
        }
        return $list;
    }


    /**
     * Находит все непрочитанные уведомления связанные с записью/фото/видео
     *
     * @param $user_id int пользователь которому предназначены уведомления
     * @param $entity string класс модели
     * @param $entity_id int Id модели
     * @return NotificationGroup[]
     */
    public function getUnreadContentNotifications($user_id, $entity, $entity_id)
    {
        $models = array();
        $cursor = $this->getCollection()->find(array(
            'recipient_id' => (int)$user_id,
            'read' => 0,
            'entity' => $entity,
            'entity_id' => (int)$entity_id,
        ));

        while ($cursor->hasNext())
            $models [] = Notification::createNotification($cursor->getNext());

        return $models;
    }

    /**
     * Создаение объекта из массива для удобной работы с ним
     * @param $object
     * @return Notification|null
     */
    public static function createNotification($object)
    {
        switch ($object['type']) {
            case self::USER_CONTENT_COMMENT:
                $class = 'NotificationUserContentComment';
                break;
            case self::REPLY_COMMENT:
                $class = 'NotificationReplyComment';
                break;
            case self::DISCUSS_CONTINUE:
                $class = 'NotificationDiscussContinue';
                break;
            case self::NEW_LIKE:
                $class = 'NotificationLikes';
                break;
            case self::NEW_FAVOURITE:
                $class = 'NotificationFavourites';
                break;
            case self::NEW_REPOST:
                $class = 'NotificationReposts';
                break;
        }

        if (!isset($class))
            return null;

        $model = new $class;
        foreach ($object as $key => $value)
            $model->$key = $value;

        return $model;
    }

    /**
     * Удаление старых уведомлений, которые были прочитаны более 10-ти дней назад
     * и которые были создано более 100 дней назад, но не были причитаны
     */
    public function removeOldReadNotifications()
    {
        $this->getCollection()->remove(array(
            'read_time' => array('$lt' => (time() - 3600 * 24 * 10))
        ));

        $this->getCollection()->remove(array(
            'updated' => array('$lt' => (time() - 3600 * 24 * 100)),
            'read_time' => array('$exists' => false)
        ));
    }

    /**
     * Отображаемое количество уведомлений
     * @return int
     */
    public function getVisibleCount()
    {
        return 1;
    }

    /**
     * Удаляем все уведомления связанные с уделанной сущностью
     * @param $entity CActiveRecord
     */
    public function entityRemoved($entity)
    {
        $this->getCollection()->remove(array(
            'entity' => get_class($entity),
            'entity_id' => $entity->id,
        ));
    }

    /**
     * @param CActiveRecord $model
     * @param int $form форма слова
     * @return string
     */
    public static function getContentName($model, $form = 0)
    {
        if ($form == 1) {
            switch (get_class($model)) {
                case 'AlbumPhoto':
                    return 'фото';
                case 'CookRecipe':
                    return 'рецепта';
                case 'CommunityContent':
                    if ($model->type_id == CommunityContent::TYPE_VIDEO)
                        return 'видео';
                    if ($model->type_id == CommunityContent::TYPE_STATUS)
                        return 'статуса';
                    break;
            }

            return 'записи';
        }

        switch (get_class($model)) {
            case 'AlbumPhoto':
                return 'фото';
            case 'CookRecipe':
                return 'рецепту';
            case 'CommunityContent':
                if ($model->type_id == CommunityContent::TYPE_VIDEO)
                    return 'видео';
                if ($model->type_id == CommunityContent::TYPE_STATUS)
                    return 'статусу';
                break;
        }

        return 'записи';
    }
}