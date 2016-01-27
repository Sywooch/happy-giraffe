<?php
/**
 * @author Никита
 * @date 26/12/14
 */

class ApiController extends \site\frontend\components\api\ApiController
{
    public function actionGetUserSubscriptions($userId)
    {
        $criteria = new CDbCriteria();
        $criteria->compare('user_id', $userId);
        $subscriptions = UserClubSubscription::model()->with('club')->findAll($criteria);

        $this->data = array_map(function($model) {
            return array(
                'id' => $model->club_id,
                'sectionId' => $model->club->section_id,
                'url' => $model->club->getUrl(),
                'title' => $model->club->title,
            );
        }, $subscriptions);
        $this->success = true;
    }

    public function actionSetUserSubscriptions($userId, array $subscriptions)
    {
        UserClubSubscription::model()->deleteAll('user_id = :userId', array(':userId' => $userId));

        foreach ($subscriptions as $s) {
            $sub = new UserClubSubscription();
            $sub->club_id = $s;
            $sub->user_id = $userId;
            $sub->save();
        }

        /** @todo костыль, убрать когда переделаем подписки */
        sleep(1);
        \site\frontend\modules\posts\modules\myGiraffe\components\FeedManager::updateForUser($userId);

        $this->success = true;
    }
} 