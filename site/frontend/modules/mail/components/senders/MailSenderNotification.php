<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 18/04/14
 * Time: 13:55
 * To change this template use File | Settings | File Templates.
 */

Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
Yii::import('site.frontend.modules.notifications.models.base.*');
Yii::import('site.frontend.modules.notifications.models.*');
Yii::import('site.frontend.modules.notifications.components.*');

class MailSenderNotification extends MailSender
{
    public $debugMode = self::DEBUG_PRODUCTION;

    const TYPE_DISCUSS = 'notificationDiscuss';
    const TYPE_REPLY = 'notificationReply';
    const TYPE_COMMENT = 'notificationComment';

    protected $typesMap = array(
        self::TYPE_DISCUSS => Notification::DISCUSS_CONTINUE,
        self::TYPE_REPLY => Notification::REPLY_COMMENT,
        self::TYPE_COMMENT => Notification::USER_CONTENT_COMMENT,
    );

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function process(User $user)
    {
        echo $user->id . "\n";

        $notifications = Notification::model()->getNotificationsList($user->id, 0, 0, 999);

        foreach ($notifications as $notification) {
            $this->checkSubscribesSettings($user, $notification);

            if (($notification->updated < strtotime($this->lastDeliveryTimestamp)) || ($notification->updated > $this->startTime)) {
                continue;
            }

            if ($this->typesMap[$this->type] != $notification->type) {
                continue;
            }

            $model = CActiveRecord::model($notification->entity)->findByPk($notification->entity_id);

            if ($model === null) {
                continue;
            }

            $commentsIds = $notification->unread_model_ids;
            $criteria = new CDbCriteria();
            $criteria->limit = MailMessageNotification::COMMENTS_COUNT;
            $criteria->order = 't.created DESC';
            $criteria->addInCondition('t.id', $commentsIds);
            $commentsToShow = MailComment::model()->findAll($criteria);
            $totalCommentsCount = count($commentsIds);

            $messageClass = $this->getMessageClassByNotification($notification);

            $params = compact('model', 'commentsToShow', 'totalCommentsCount');
            if ($notification->type == Notification::REPLY_COMMENT) {
                $comment = MailComment::model()->findByPk($notification->comment_id);
                if ($comment === null) {
                    continue;
                }
                $params['comment'] = $comment;
            }
            $message = new $messageClass($user, $params);
            $this->send($message);
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

    protected function checkSubscribesSettings(User $user, Notification $notification)
    {
        if ($notification->type == Notification::DISCUSS_CONTINUE) {
            if (UserAttributes::get($user->id, 'discussions', true) !== true) {
                return;
            }
        }

        if ($notification->type == Notification::REPLY_COMMENT) {
            if (UserAttributes::get($user->id, 'replies', true) !== true) {
                return;
            }
        }

        if ($notification->type == Notification::USER_CONTENT_COMMENT) {
            if ($notification instanceof NotificationGroup) {
                $model = $notification->getEntity();
                if ($model instanceof CommunityContent && $model->type_id == CommunityContent::TYPE_QUESTION) {
                    $setting = 'answers';
                } else {
                    $setting = 'comments';
                }
            }

            if (UserAttributes::get($user->id, $setting, true) !== true) {
                return;
            }
        }
    }

    protected function getUsersCriteria()
    {
        $criteria = parent::getUsersCriteria();
        return $criteria->compare('online', 0);
    }
}