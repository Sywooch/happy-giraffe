<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 18/04/14
 * Time: 13:55
 * To change this template use File | Settings | File Templates.
 */

class MailSenderNotification extends MailSender
{
    public function process(User $user)
    {
        $lastDelivery = MailDelivery::model()->getLastDelivery($user->id, 'dialogues');
        $notifications = Notification::model()->getNotificationsList($user->id, 0, 0, 999);

        foreach ($notifications as $notification) {
            $model = CActiveRecord::model($notification->entity)->findByPk($notification->entity_id);
            $commentsIds = $notification->unread_model_ids;
            $criteria = new CDbCriteria();
            $criteria->limit = 5;
            $criteria->order = 't.created DESC';
            $criteria->addInCondition('t.id', $commentsIds);
            $commentsToShow = MailComment::model()->findAll($criteria);
            $totalCommentsCount = count($commentsIds);

            $messageClass = $this->getMessageClassByNotification($notification);
            $message = new $messageClass($user, compact('model', 'commentsToShow', 'totalCommentsCount'));
            Yii::app()->postman->send($message);
        }
    }

    protected function getMessageClassByNotification(Notification $notification)
    {
        switch ($notification->type) {
            case Notification::DISCUSS_CONTINUE:
                return 'MailMessageNotificationDiscuss';
            case Notification::REPLY_COMMENT:
                return 'MailMessageNotificationReply';
            case Notification::USER_CONTENT_COMMENT:
                return 'MailMessageNotificationComment';
        }
    }

    protected function getUsersCriteria()
    {
        $criteria = parent::getUsersCriteria();
        return $criteria->compare('online', 0);
    }
}