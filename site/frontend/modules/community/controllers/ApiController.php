<?php
/**
 * @author Никита
 * @date 26/12/14
 */

class ApiController extends \site\frontend\components\api\ApiController
{
    public function actionGetUserSubscriptions($userId)
    {
        $subscriptions = UserClubSubscription::model()->with('club')->findAllByAttributes(array('user_id' => $userId));

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