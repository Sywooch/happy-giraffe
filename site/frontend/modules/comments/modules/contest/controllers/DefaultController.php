<?php
/**
 * @author Никита
 * @date 26/02/15
 */

namespace site\frontend\modules\comments\modules\contest\controllers;


use site\frontend\modules\comments\modules\contest\models\CommentatorsContest;
use site\frontend\modules\comments\modules\contest\models\CommentatorsContestParticipant;

class DefaultController extends \LiteController
{
    public $layout = '/layout';
    public $litePackage = 'contest_commentator';
    public $bodyClass = 'body__contest-commentator';
    public $contest;

    public function actionIndex($contestId)
    {
        $this->loadContest($contestId);
        $this->render('/index');
    }

    public function actionRating($contestId)
    {
        $participant = CommentatorsContestParticipant::model()->contest($contestId)->user(\Yii::app()->user->id)->find();
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

    protected function loadContest($contestId)
    {
        $this->contest = CommentatorsContest::model()->findByPk($contestId);
        if ($this->contest === null) {
            throw new \CHttpException(404);
        }
    }
}