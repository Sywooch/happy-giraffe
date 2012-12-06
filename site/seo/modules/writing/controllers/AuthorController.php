<?php
/**
 * Author: alexk984
 * Date: 02.04.12
 */
class AuthorController extends SController
{
    public $layout = '//layouts/writing';

    public function beforeAction($action)
    {
        if (!Yii::app()->user->checkAccess('author') && !Yii::app()->user->checkAccess('rewrite-author'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        if (Yii::app()->user->checkAccess('author'))
            $this->pageTitle = 'автор';
        else
            $this->pageTitle = 'рератер';

        return true;
    }

    public function actionIndex()
    {
        $tasks = SeoTask::getTasks();
        $executing = SeoTask::getActiveTask();

        $this->render('_author', compact('tasks', 'executing'));
    }

    public function actionReports()
    {
        $this->pageTitle = 'автор';
        $tasks = SeoTask::TodayExecutedTasks();
        $this->render('_author_reports', compact('tasks'));
    }
}
