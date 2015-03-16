<?php
/**
 * @author Никита
 * @date 26/02/15
 */

namespace site\frontend\modules\comments\modules\contest\controllers;


use site\frontend\modules\comments\modules\contest\models\CommentatorsContest;
use site\frontend\modules\comments\modules\contest\models\CommentatorsContestParticipant;
use site\frontend\modules\posts\models\Content;

class DefaultController extends \LiteController
{
    public $layout = '/layout';
    public $litePackage = 'contest_commentator';
    public $bodyClass = 'body__contest-commentator';
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

    public function actionIndex($contestId)
    {
        $this->loadContest($contestId);
        $this->render('/index');
    }

    public function actionRating($contestId)
    {
        $this->loadContest($contestId);
        $this->render('/rating', compact('participant'));
    }

    public function actionRules($contestId)
    {
        $this->loadContest($contestId);
        $this->render('/rules');
    }

    public function actionMy($contestId)
    {
        $this->loadContest($contestId);
        $this->render('/my');
    }

    public function actionPosts($contestId)
    {
        $this->loadContest($contestId);
        $this->render('/posts');
    }

    public function actionCounts($contestId)
    {
        echo CommentatorsContestParticipant::model()->contest($contestId)->count();
    }

    protected function loadContest($contestId)
    {
        $this->contest = CommentatorsContest::model()->findByPk($contestId);
        if ($this->contest === null) {
            throw new \CHttpException(404);
        }
    }
}