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
    const SORT_CREATED = 0;
    const SORT_RATE = 1;

    public function actionIndex($contestId, $sort = self::SORT_CREATED)
    {
        $contest = CommunityContest::model()->with('forum', 'contestWorks')->findByPk($contestId);
        if ($contest === null)
            throw new CHttpException(404);

        $works = $contest->getContestWorks($sort);

        $this->bodyClass = 'theme-contest theme-contest__pets1';
        if (Yii::app()->user->isGuest)
            $this->bodyClass .= 'body-guest';
        $this->render('index', compact('contest', 'works'));
    }
}