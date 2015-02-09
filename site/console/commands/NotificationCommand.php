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
        Yii::import('site.common.models.mongo.*');
        Yii::import('site.frontend.modules.contest.models.*');
        Yii::import('site.frontend.modules.favourites.models.*');
        Yii::import('site.frontend.modules.cook.models.*');
    }

    public function actionDiscuss()
    {
        NotificationDiscussSubscription::model()->createDiscussNotifications();
    }

    public function actionLikes()
    {
        NotificationCreate::generateLikes();
        NotificationCreate::generateFavourites();
        NotificationCreate::generateReposts();
    }

    public function actionRemove()
    {
        Notification::model()->removeOldReadNotifications();
    }
}