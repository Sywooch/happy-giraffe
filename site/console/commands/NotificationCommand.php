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

        Yii::import('site.frontend.modules.notification.models.base.*');
        Yii::import('site.frontend.modules.notification.models.*');
        Yii::import('site.frontend.modules.notification.components.*');
    }

    public function actionDiscuss()
    {
        NotificationDiscussSubscription::model()->createDiscussNotifications();
    }
}