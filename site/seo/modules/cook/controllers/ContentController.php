<?php
/**
 * Author: alexk984
 * Date: 02.04.12
 */
class ContentController extends SController
{
    public $layout = '//layouts/cook';

    public function beforeAction($action)
    {
        if (!Yii::app()->user->checkAccess('cook-content-manager'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $this->pageTitle = 'контент';
        return true;
    }

    public function actionIndex()
    {
        $tasks = SeoTask::getTasks();
        $this->render('_cm', compact('tasks'));
    }

    public function actionReports()
    {
        $tasks = SeoTask::TodayExecutedTasks();
        $this->render('_cm_reports', compact('tasks'));
    }
}
