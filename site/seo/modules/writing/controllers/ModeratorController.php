<?php
/**
 * Author: alexk984
 * Date: 02.04.12
 */
class ModeratorController extends SController
{
    public $layout = '//layouts/writing';

    public function actionModerator()
    {
        if (!Yii::app()->user->checkAccess('moderator'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $this->pageTitle = 'модератор';

        $tasks = SeoTask::getTasks();
        $executing = SeoTask::getActiveTask();

        $this->render('_moderator', compact('tasks', 'executing'));
    }

    public function actionModeratorReports()
    {
        if (!Yii::app()->user->checkAccess('moderator'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $this->pageTitle = 'модератор';
        $tasks = SeoTask::TodayExecutedTasks();
        $this->render('_moderator_reports', compact('tasks'));
    }
}
