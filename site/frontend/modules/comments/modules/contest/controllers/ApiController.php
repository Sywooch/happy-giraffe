<?php
namespace site\frontend\modules\comments\modules\contest\controllers;
use site\frontend\modules\comments\modules\contest\components\ContestManager;
use site\frontend\modules\comments\modules\contest\models\CommentatorsContest;
use site\frontend\modules\comments\modules\contest\models\CommentatorsContestComment;
use site\frontend\modules\comments\modules\contest\models\CommentatorsContestParticipant;

/**
 * @author Никита
 * @date 20/02/15
 */

class ApiController extends \site\frontend\components\api\ApiController
{
    public function actionRegister()
    {
        $contest = CommentatorsContest::model()->active()->find();
        if ($contest !== null) {
            $this->success = $contest->register(\Yii::app()->user->id);
        }
    }

    public function actionRatingList($contestId, $limit, $offset = 0)
    {
        $participants = CommentatorsContestParticipant::model()->contest($contestId)->orderDesc()->findAll(array(
            'limit' => $limit,
            'offset' => $offset,
        ));

        $data = array();
        foreach ($participants as $p) {
            $data[$p->userId] = $p->toJSON();
        }

        $users = \CJSON::decode(\Yii::app()->api->request('users', 'get', array(
            'pack' => array_map(function($participant) {
                return array(
                    'id' => $participant->userId,
                    'avatarSize' => \Avatar::SIZE_MEDIUM,
                );
            }, $participants),
        )));

        foreach ($users['data'] as $user) {
            $data[$user['data']['id']]['user'] = $user['data'];
        }

        $this->data = array_values($data);
        $this->success = true;
    }

    public function actionComments($contestId, $limit, $offset = 0, $userId = null)
    {
        $model = CommentatorsContestComment::model()->orderDesc()->counts(true);
        if ($userId === null) {
            $model->user($userId);
        } else {
            $model->contest($contestId);
        }
        $comments = $model->findAll(array(
            'limit' => $limit,
            'offset' => $offset,
        ));
        $this->data = $comments;
        $this->success = true;
    }
}