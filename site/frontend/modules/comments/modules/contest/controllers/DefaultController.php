<?php

namespace site\frontend\modules\comments\modules\contest\controllers;


use site\frontend\modules\comments\modules\contest\components\ContestManager;
use site\frontend\modules\comments\modules\contest\models\CommentatorsContest;
use site\frontend\modules\comments\modules\contest\models\CommentatorsContestParticipant;
use site\frontend\modules\posts\models\Content;

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
                'actions' => array('my', 'posts'),
                'users' => array('?'),
            ),
            array('allow',
                'actions' => array('counts'),
                'roles' => array('moderator'),
            ),
            array('deny',
                'actions' => array('counts'),
                'users' => array('*'),
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

//    public function actionRating($contestId)
//    {
//        $this->loadContest($contestId);
//        $this->render('/rating', compact('participant'));
//    }
//
//    public function actionRules($contestId)
//    {
//        $this->loadContest($contestId);
//        $this->render('/rules');
//    }
//
//    public function actionMy($contestId)
//    {
//        $this->loadContest($contestId);
//        $this->render('/my');
//    }
//
//    public function actionComments($contestId)
//    {
//        $this->loadContest($contestId);
//        $this->render('/comments');
//    }
//
//    public function actionPosts($contestId)
//    {
//        $this->loadContest($contestId);
//        $this->render('/posts');
//    }
//
//    public function actionCounts($contestId)
//    {
//        echo CommentatorsContestParticipant::model()->byContest($contestId)->count();
//    }

    protected function loadContest()
    {
        $this->contest = ContestManager::getCurrentActive();
        if (!$this->contest) {
            throw new \HttpException(404);
        }
    }
}