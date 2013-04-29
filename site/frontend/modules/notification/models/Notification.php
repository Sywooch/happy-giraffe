<?php
/**
 * Class Notification
 *
 * Уведомление пользователю
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class Notification
{
    /**
     * @var Notification
     */
    protected static $_instance;

    const NEW_COMMENT = 0;
    const REPLY_COMMENT = 1;
    const NEW_LIKE = 2;

    public $type;
    public $updated;
    public $recipient_id;
    public $read = 0;

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

    /**
     * @return MongoCollection
     */
    public static function getCollection()
    {
        return Yii::app()->edmsMongoCollection('notifications_new');
    }

    /**
     * Добавляет индекс если не создан
     */
    public static function ensureIndex()
    {
        self::getCollection()->ensureIndex(array(
            'updated' => EMongoCriteria::SORT_DESC,
            'recipient_id' => EMongoCriteria::SORT_DESC,
        ));
    }

    protected function afterSave()
    {
        $comet = new CometModel;
        $comet->send($this->recipient_id, array(), CometModel::TYPE_NEW_NOTIFICATION);
    }

    public function getUserCriteria($user_id)
    {
        $criteria = new EMongoCriteria;
        $criteria->recipient_id = (int)$user_id;
        $criteria->sort('updated', EMongoCriteria::SORT_DESC);
        return $criteria;
    }
}