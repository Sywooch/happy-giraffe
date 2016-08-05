<?php

namespace site\frontend\modules\comments\modules\contest\controllers;

use site\frontend\modules\comments\modules\contest\components\ContestManager;
use site\frontend\modules\comments\modules\contest\models\CommentatorsContest;
use site\frontend\modules\comments\modules\contest\models\CommentatorsContestParticipant;
use site\frontend\modules\comments\modules\contest\models\CommentatorsContestComment;

/**
 * @property CommentatorsContest $contest
 */
class DefaultController extends \LiteController
{
    public $layout = '/layout';
    public $litePackage = 'contest_commentator';
    public $bodyClass = 'body_competition';
    public $contest;

    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('deny',
                'actions' => array('my', 'quests'),
                'users' => array('?'),
            ),
        );
    }

    protected function beforeAction($action)
    {
        $this->loadContest();
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $this->render('/index');
    }

    public function actionRules()
    {
        $this->render('/rules');
    }

    public function actionQuests()
    {
        $this->render('/quests');
    }

    /**
     * @param int $contestId
     */
    public function actionWinners($contestId = null)
    {
        /**
         * @var CommentatorsContest[] $contests
         */
        $contests = CommentatorsContest::model()
            ->findAll(array(
                'order' => 'id DESC',
                'limit' => 4,
            ));

        if (!$contestId) {
            $contestId = !\Yii::app()->user->isGuest ? $contests[0]->id : $contests[1]->id;
        }

        $this->render('/winners', array(
            'contests' => $contests,
            'winners' => $this->getWinners($contestId),
            'contestId' => $contestId,
        ));
    }

    private function getWinners($contestId)
    {
        return CommentatorsContestParticipant::model()
            ->byContest($contestId)
            ->orderByScore()
            ->findAll(array(
                'limit' => 10,
        ));
    }

    public function actionMy()
    {
        $participant = CommentatorsContestParticipant::model()
            ->byContest($this->contest->id)
            ->byUser(\Yii::app()->user->id)
            ->with('user')
            ->find();

        $comments = CommentatorsContestComment::model()
            ->byContest($this->contest->id)
            ->byParticipant($participant->id)
            ->with('comment')
            ->findAll(array(
                'limit' => 5,
            ));

        $this->render('/my', array(
            'comments' => $comments,
            'participant' => $participant,
        ));
    }

    public function actionPulse()
    {
        $comments = array();

        /**
         * @var CommentatorsContestComment[] $contestComments
         */
        $contestComments = CommentatorsContestComment::model()
            ->orderDesc()
            ->byContest($this->contest->id)
            ->with('comment')
            ->findAll(array(
                'limit' => 10,
            ));

        foreach ($contestComments as $c) {
            $comments[] = $c->comment;
        }

        $participantsCount = CommentatorsContestParticipant::model()
            ->byContest($this->contest->id)
            ->count();

        $commentsCount = CommentatorsContestComment::model()
            ->byContest($this->contest->id)
            ->count();

        $this->render('/pulse', array(
            'comments' => $comments,
            'participantsCount' => $participantsCount,
            'commentsCount' => $commentsCount,
        ));
    }

    protected function loadContest()
    {
        $this->contest = ContestManager::getCurrentActive();
        if (!$this->contest) {
            throw new \HttpException(404);
        }
    }
}