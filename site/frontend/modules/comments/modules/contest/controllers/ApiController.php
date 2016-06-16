<?php

namespace site\frontend\modules\comments\modules\contest\controllers;

use site\frontend\modules\comments\modules\contest\components\ContestManager;
use site\frontend\modules\comments\modules\contest\models\CommentatorsContest;
use site\frontend\modules\comments\modules\contest\models\CommentatorsContestComment;
use site\frontend\modules\comments\modules\contest\models\CommentatorsContestParticipant;
use site\frontend\modules\posts\models\Content;

/**
 * @author Никита
 * @date 20/02/15
 */
class ApiController extends \site\frontend\components\api\ApiController
{

    public function actionRegister()
    {
        $contest = CommentatorsContest::model()->active()->find();
        if ($contest !== null)
        {
            $this->success = $contest->register(\Yii::app()->user->id);
            $this->data = array(
                'redirectUrl' => $this->createUrl('/comments/contest/default/my', array('contestId' => $contest->id)),
            );
        }
    }

    public function actionRatingList($contestId, $limit, $offset = 0)
    {
        $participants = CommentatorsContestParticipant::model()->contest($contestId)->top()->findAll(array(
            'limit' => $limit,
            'offset' => $offset,
        ));

        $data = array();
        foreach ($participants as $p)
        {
            $data[$p->userId] = $p->toJSON();
        }

        $tmpFunct = function($participant)
        {
            return array('id' => $participant->userId, 'avatarSize' => \Avatar::SIZE_MEDIUM,);
        };

        $users = \CJSON::decode(\Yii::app()->api->request('users', 'get', array('pack' => array_map($tmpFunct, $participants))));

        foreach ($users['data'] as $user)
        {
            $data[$user['data']['id']]['user'] = $user['data'];
        }

        $this->data = array_values($data);
        $this->success = true;
    }

    public function actionComments($contestId, $limit, $offset = 0, $userId = null)
    {
        $model = CommentatorsContestComment::model()->orderDesc()->contest($contestId)->counts(true);
        if ($userId !== null)
        {
            $model->user($userId);
        }
        $comments = $model->findAll(array(
            'limit' => $limit,
            'offset' => $offset,
        ));
        $this->data = $comments;
        $this->success = true;
    }

    public function actionToggle($modelPk)
    {
        $this->success = false;
        if (!\Yii::app()->user->checkAccess('moderator'))
        {
            return;
        }
        $content = Content::model()->findByPk($modelPk);
        if ($content == null)
        {
            return;
        }
        $favourites = \Favourites::model()->toggle($content->communityContent, \Favourites::BLOCK_COMMENTATORS_CONTEST);
        $this->data = array('active' => \Favourites::model()->inFavourites($content->communityContent, \Favourites::BLOCK_COMMENTATORS_CONTEST));
        $this->success = true;
    }

}
