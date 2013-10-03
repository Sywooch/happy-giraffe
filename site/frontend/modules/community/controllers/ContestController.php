<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 10/3/13
 * Time: 11:43 AM
 * To change this template use File | Settings | File Templates.
 */

class ContestController extends HController
{
    public function actionIndex($contestId)
    {
        $contest = CommunityContest::model()->with('club')->findByPk($contestId);
        if ($contest === null)
            throw new CHttpException(404);

        $this->bodyClass = 'theme-contest theme-contest__pets1';
        if (Yii::app()->user->isGuest)
            $this->bodyClass .= 'body-guest';
        $this->render('index', compact('contest'));
    }
}