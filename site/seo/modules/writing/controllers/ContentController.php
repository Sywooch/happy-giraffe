<?php
/**
 * Author: alexk984
 * Date: 02.04.12
 */
class ContentController extends SController
{
    public $layout = '//layouts/writing';

    public function beforeAction($action)
    {
        if (!Yii::app()->user->checkAccess('corrector'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $this->pageTitle = 'корректор';
        return true;
    }

    public function actionContentManager()
    {
        if (!Yii::app()->user->checkAccess('content-manager'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $this->pageTitle = 'контент-менеджер';
        $tasks = SeoTask::getTasks();
        $this->render('_cm', compact('tasks'));
    }

    public function actionContentManagerReports()
    {
        if (!Yii::app()->user->checkAccess('content-manager'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $this->pageTitle = 'контент-менеджер';
        $tasks = SeoTask::TodayExecutedTasks();
        $this->render('_cm_reports', compact('tasks'));
    }
}
