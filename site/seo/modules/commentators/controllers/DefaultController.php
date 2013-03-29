<?php

class DefaultController extends SController
{
    public $layout = '/layout/commentators';
    public $icon = 2;
    public $user;

    public function beforeAction($action)
    {
        if (!Yii::app()->user->checkAccess('commentator-manager-panel'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        Yii::import('site.frontend.modules.signal.models.*');
        Yii::import('site.frontend.modules.signal.components.*');
        Yii::import('site.frontend.modules.im.models.*');

        $this->pageTitle = 'комментаторы';
        $this->user = Yii::app()->user->getModel();
        return true;
    }

    public function actionIndex()
    {
        $this->render('tasks');
    }

    public function actionAward($month = null)
    {
        if (empty($month))
            $month = date("Y-m");

        $this->render('awards', compact('month'));
    }

    public function actionLinks($user_id = null, $month = null)
    {
        if (empty($month))
            $month = date("Y-m");

        if (empty($user_id))
            $this->render('links_all', compact('month'));
        else {
            $this->addEntityToFastList('commentators', $user_id, 3);
            $commentator = CommentatorWork::getUser($user_id);
            $this->render('links', compact('month', 'commentator'));
        }
    }

    public function actionReports($user_id = null, $month = null){
        if (empty($month))
            $month = date("Y-m");

        if (empty($user_id))
            $this->render('reports_all', compact('month'));
        else {
            $this->addEntityToFastList('commentators', $user_id, 3);
            $commentator = CommentatorWork::getUser($user_id);
            $this->render('reports', compact('month', 'commentator'));
        }
    }
}