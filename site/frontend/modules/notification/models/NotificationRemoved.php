<?php
/**
 * Class NotificationReplyComment
 *
 * Уведомление пользователю об удалении его контента
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class NotificationRemoved extends Notification
{
    public $entity;
    public $entity_id;
    public $model;

    public function setSpecificValues()
    {
        $this->model = CActiveRecord::model($this->entity)->findByPk($this->entity_id);
    }
}