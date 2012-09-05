<?php
/**
 * Author: alexk984
 * Date: 02.04.12
 */
class CorrectorController extends SController
{
    public $layout = '//layouts/writing';

    public function beforeAction($action)
    {
        if (!Yii::app()->user->checkAccess('corrector'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $this->pageTitle = 'корректор';
        return true;
    }

    public function actionIndex()
    {
        $tasks = SeoTask::getTasks();
        $executing = SeoTask::getActiveTask();

        $this->render('_corrector', compact('tasks', 'executing'));
    }

    public function actionReports()
    {
        $tasks = SeoTask::TodayExecutedTasks();
        $this->render('_corrector_reports', compact('tasks'));
    }

    public function actionCorrected()
    {
        $task_id = Yii::app()->request->getPost('id');
        $task = $this->loadTask($task_id);
        if ($task->status == SeoTask::STATUS_CORRECTING) {
            $task->status = SeoTask::STATUS_CORRECTED;
            echo CJSON::encode(array('status' => $task->save()));
        } else
            echo CJSON::encode(array('status' => false));

    }

    /**
     * @param int $id model id
     * @return SeoTask
     * @throws CHttpException
     */
    public function loadTask($id)
    {
        $model = SeoTask::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }
}
