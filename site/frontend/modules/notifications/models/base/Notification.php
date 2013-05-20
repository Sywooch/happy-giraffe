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
    protected $_collection_name = 'notifications_new';

    const USER_CONTENT_COMMENT = 0;
    const REPLY_COMMENT = 1;
    const DISCUSS_CONTINUE = 2;
    const NEW_LIKE = 5;

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

        $ops = array(
            array(
                '$match' => array(
                    "recipient_id" => (int)$user_id,
                    "read" => 0,
                )
            ),
            array(
                '$group' => array(
                    "_id" => 0,
                    "count" => array('$sum' => '$count'),
                ),
            ),
        );
        $result = $this->getCollection()->aggregate($ops);
        return isset($result['result'][0]) ? $result['result'][0]['count'] : 0;
    }

    /**
     * Возвращает список уведомлений для вывода пользователю
     *
     * @param $user_id int id пользователя
     * @param int $read
     * @param $page int номер страницы с уведомлениями
     * @return Notification[]
     */
    public function getNotificationsList($user_id, $read = 0, $page = 0)
    {
        $cursor = $this->getCollection()->find(array(
            'recipient_id' => (int)$user_id,
            'read' => $read
        ))->sort(array('updated' => -1))->limit(self::PAGE_SIZE)->skip($page * self::PAGE_SIZE);

        $list = array();
        for ($i = 0; $i < self::PAGE_SIZE; $i++) {
            if ($cursor->hasNext())
                $list [] = self::createNotification($cursor->getNext());
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
                return NotificationUserContentComment::createModel($object);
            case self::REPLY_COMMENT:
                return NotificationReplyComment::createModel($object);
            case self::DISCUSS_CONTINUE:
                return NotificationDiscussContinue::createModel($object);
            case self::NEW_LIKE:
                return NotificationLike::createModel($object);
        }
        return null;
    }

    /**
     * Удаление старых уведомлений, которые были прочитаны более 10-ти дней назад
     */
    public function removeOldReadNotifications()
    {
        $this->getCollection()->remove(array(
            'read_time' => array('$lt' => (time() - 3600 * 24 * 10))
        ));
    }

    /**
     * @return CActiveRecord
     */
    public function getContent(){
        return null;
    }
}