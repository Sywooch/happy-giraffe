<?php
/**
 * Class NotificationReplyComment
 *
 * Уведомление пользователю о лайке его контента
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class NotificationLike extends Notification
{
    public $type = self::NEW_LIKE;
    public $entity;
    public $entity_id;
    public $model;

    public function setSpecificValues()
    {
        $this->model = CActiveRecord::model($this->entity)->findByPk($this->entity_id);
    }

    public static function create($recipient_id, $entity, $entity_id)
    {
        self::ensureIndex();
        self::getCollection()->insert(
            array(
                'type' => self::NEW_LIKE,
                'recipient_id' => (int)$recipient_id,
                'updated' => time(),
                'entity' => $entity,
                'entity_id' => (int)$entity_id,
            )
        );
    }
}