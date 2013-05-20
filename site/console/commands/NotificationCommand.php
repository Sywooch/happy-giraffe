<?php
/**
 * insert Description
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class NotificationCommand extends CConsoleCommand
{
    public function init()
    {
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');

        Yii::import('site.frontend.modules.notifications.models.base.*');
        Yii::import('site.frontend.modules.notifications.models.*');
        Yii::import('site.frontend.modules.notifications.components.*');
    }

    public function actionDiscuss()
    {
        NotificationDiscussSubscription::model()->createDiscussNotifications();
    }

    public function actionLikes()
    {
        Yii::import('site.common.models.mongo.*');
        Yii::import('site.frontend.modules.contest.models.*');
        NotificationCreate::generateLikes();
    }

    public function actionTest()
    {
        for ($i = 0; $i < 100; $i++)
            Notification::model()->insertTest();
    }

    public function actionDeleteOld()
    {
        Notification::model()->removeOldReadNotifications();
    }
}