<?php
/**
 * Author: alexk984
 * Date: 02.04.12
 */
class AuthorController extends SController
{
    public $layout = '//layouts/cook';
    public $icon = 2;

    public function beforeAction($action)
    {
        if (!Yii::app()->user->checkAccess('cook-author'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $this->pageTitle = 'кулинар';
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
        $tasks = SeoTask::TodayExecutedTasks();
        $this->render('_author_reports', compact('tasks'));
    }

    public function actionExecuted()
    {
        $title = Yii::app()->request->getPost('name');
        $task = $this->loadTask(Yii::app()->request->getPost('id'));
        $task->status = SeoTask::STATUS_WRITTEN;
        if (empty($task->keyword_group_id)){
            $keyword = Keyword::GetKeyword($task->article_title);
            $group = new KeywordGroup();
            $group->keywords = array($keyword);
            if (!$group->save())
                var_dump($group->getErrors());

            $task->keyword_group_id = $group->id;
        }

        if (empty($title) && empty($task->article_title))
            echo CJSON::encode(array('status' => false, 'error' => 'Введите название рецепта'));
        else {
            if (!empty($title))
                $task->article_title = $title;

            if (empty($task->article_title)) {
                echo CJSON::encode(array('status' => false, 'error' => 'Введите название рецепта'));
            } else
                echo CJSON::encode(array('status' => $task->save()));
        }
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
