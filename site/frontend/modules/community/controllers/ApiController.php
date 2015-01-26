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
            );
        }, $subscriptions);
        $this->success = true;
    }
} 