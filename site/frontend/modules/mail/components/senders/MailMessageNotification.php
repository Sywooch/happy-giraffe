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
        $notifications = Notification::model()->getNotificationsList($user->id, 0, 0, 999);

        foreach ($notifications as $notification) {
            switch ($notification->type) {
                case Notification::DISCUSS_CONTINUE:
                    $model = CActiveRecord::model($notification->entity)->findByPk($notification->entity_id);
                    $commentsIds = $notification->unread_model_ids;
                    $criteria = new CDbCriteria();
                    $criteria->limit = 5;
                    $criteria->order = 't.created DESC';
                    $criteria->addInCondition('t.id', $commentsIds);
                    $commentsToShow = MailComment::model()->findAll($criteria);
                    $totalCommentsCount = count($commentsIds);
                    $message = new MailMessageNotificationDiscuss($user, compact('model', 'commentsToShow', 'totalCommentsCount'));
                    $this->sendMessage($message);
                    break;
            }
        }
    }
}