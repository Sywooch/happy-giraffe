<?php
/**
 * Подписка на контент
 * 
 * @author Alex Kireev <alexk984@gmail.com>
 */
class NotificationDiscussSubscription {
    /**
     * @var string класс сущности
     */
    public $entity;
    /**
     * @var int id элемента
     */
    public $entity_id;
    /**
     * @var int id пользователя, подписавшегося на тему
     */
    public $recipient_id;
    public $last_comment_id;

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
            'entity' => EMongoCriteria::SORT_DESC,
            'recipient_id' => EMongoCriteria::SORT_DESC,
            'read' => EMongoCriteria::SORT_DESC,
        ), array('name' => 'list_index'));
    }


}