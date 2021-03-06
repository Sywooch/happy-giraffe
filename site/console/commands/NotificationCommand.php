<?php

use site\frontend\modules\som\modules\qa\models\QaAnswer;

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

    public function actionSendNotifications()
    {
        \Yii::app()->db->enableSlave = false;
        \Yii::app()->db->createCommand('SET SESSION wait_timeout = 28800;')->execute();
        
        $models = QaAnswer::model()
                    ->resetScope()
                    ->findAll([
                        'condition' => 'isPublished = ' . QaAnswer::NOT_PUBLISHED . ' AND isRemoved = ' . QaAnswer::NOT_REMOVED,
                    ])
                ;

        $cnt = 0;

        $count = new stdClass();
        $count->updated = 0;
        $count->broken = 0;
        $count->expired = 0;

        foreach ($models as $model) {
            if (!$model->question || !$model->category) { // целостность БД
                $count->broken++;

                continue;
            }

            if ($model->isTimeoutExpired) {
                $model->isPublished = 1;

                if ($model->save()) {
                    $model->notificationBehavior->sendNotification();
                    $count->updated++;
                    $cnt++;
                }
            } else {
                $count->expired++;
            }
        }

        echo "updated: {$count->updated}\n";
        echo "broken: {$count->broken}\n";
        echo "expired: {$count->expired}\n";
    }
}
