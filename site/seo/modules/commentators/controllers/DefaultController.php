<?php

class DefaultController extends SController
{
    public $layout = '/layout/commentators';
    public $icon = 2;

    public function beforeAction($action)
    {
        if (!Yii::app()->user->checkAccess('commentator-manager-panel'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        Yii::import('site.frontend.modules.signal.models.*');
        Yii::import('site.frontend.modules.signal.components.*');
        Yii::import('site.frontend.modules.im.models.*');

        $this->pageTitle = 'комментаторы';
        return true;
    }

    public function actionIndex($period = '', $day = '')
    {
        if (empty($period))
            $period = date("Y-m");

        $month = CommentatorsMonthStats::get($period);
        if (Yii::app()->user->checkAccess('commentator-manager')) {
            $criteria = new EMongoCriteria();
            $criteria->user_id('in', Yii::app()->user->model->commentatorIds());
            $commentators = CommentatorWork::model()->findAll($criteria);
        } else
            $commentators = CommentatorWork::model()->getCommentatorGroups();

        $this->render('index', compact('period', 'month', 'day', 'commentators'));
    }

    public function actionCommentator($user_id, $period = null)
    {
        $this->addEntityToFastList('commentators', $user_id);
        $commentator = CommentatorWork::getUser($user_id);
        $this->render('commentator', compact('commentator', 'period'));
    }

    public function actionCommentatorStats($user_id, $period)
    {
        $commentator = CommentatorWork::getUser($user_id);
        $this->render('_commentator_stats', compact('commentator', 'period'));
    }

    public function actionClubs()
    {
        $this->render('clubs', compact('commentator', 'period'));
    }

    public function actionAddClub()
    {
        $user_id = Yii::app()->request->getPost('user_id');
        $club_id = Yii::app()->request->getPost('club_id');
        $commentator = CommentatorWork::getUser($user_id);
        if (!in_array($club_id, $commentator->clubs)) {
            $commentator->clubs [] = $club_id;
            $commentator->save();
        }

        $this->renderPartial('_user_clubs', compact('commentator'));
    }

    public function actionRemoveClub()
    {
        $user_id = Yii::app()->request->getPost('user_id');
        $club_id = Yii::app()->request->getPost('club_id');
        $commentator = CommentatorWork::getUser($user_id);
        foreach ($commentator->clubs as $key => $club) {
            if ($club == $club_id)
                unset($commentator->clubs[$key]);
        }
        echo CJSON::encode(array('status' => $commentator->save()));
    }
}