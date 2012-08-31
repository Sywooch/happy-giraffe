<?php

class DefaultController extends SController
{
    public $layout = '/layout/commentators';

    public function beforeAction($action)
    {
        if (!Yii::app()->user->checkAccess('commentator-manager-panel'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        Yii::import('site.frontend.modules.signal.models.*');
        Yii::import('site.frontend.modules.signal.components.*');

        $this->pageTitle = 'комментаторы';
        return true;
    }

	public function actionIndex($period = '', $day = '')
	{
        if (empty($period))
            $period = date("Y-m");
        /*if (empty($day)){
            if ($period == date("Y-m"))
                $day = date('d');
            else
                $day = date('1');
        }*/

        $month = CommentatorsMonthStats::getWorkingMonth($period);
		$this->render('index', compact('period', 'month', 'day'));
	}

    public function actionCommentator($user_id)
    {
        $this->addEntityToFastList('commentators', $user_id);
        $commentator = CommentatorWork::getUser($user_id);
        $this->render('commentator', compact('commentator'));
    }
}