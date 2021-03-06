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
    public $contest;

    const SORT_CREATED = 0;
    const SORT_RATE = 1;

    public function actionIndex($cssClass, $sort = self::SORT_CREATED, $takePart = null)
    {
        $this->contest = $contest = CommunityContest::model()->with('forum', 'contestWorks')->findByAttributes(array('cssClass' => $cssClass));
        if ($contest === null)
            throw new CHttpException(404);

        $works = $contest->getContestWorks($sort);

        $this->bodyClass = 'theme-contest theme-contest__' . $contest->cssClass;
        if (Yii::app()->user->isGuest)
            $this->bodyClass .= ' body-guest';

        $this->breadcrumbs = array(
            $contest->forum->club->section->title => $contest->forum->club->section->getUrl(),
            $contest->forum->club->title => $contest->forum->club->getUrl(),
            'Конкурс «' . $contest->title . '»',
        );

        $this->pageTitle = 'Конкурс «' . $contest->title . '»';

        $this->render('index', compact('contest', 'works', 'sort', 'takePart'));
    }
}