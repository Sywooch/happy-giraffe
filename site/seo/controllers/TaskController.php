<?php
/**
 * Author: alexk984
 * Date: 02.04.12
 */
class TaskController extends SController
{
    public function actionModerator()
    {
        if (!Yii::app()->user->checkAccess('moderator'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $this->pageTitle = 'модератор';

        $tasks = SeoTask::getTasks();
        $executing = SeoTask::getActiveTask();

        $this->render('_moderator', compact('tasks', 'executing', 'success_tasks'));
    }

    public function actionAuthor()
    {
        if (!Yii::app()->user->checkAccess('author'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $tasks = SeoTask::getTasks();
        $success_tasks = SeoTask::TodayExecutedTasks();
        $this->render('_author', compact('tasks', 'success_tasks'));
    }

    public function actionCmanager()
    {
        if (!Yii::app()->user->checkAccess('content-manager'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $tasks = SeoTask::getTasks();
        $success_tasks = SeoTask::TodayExecutedTasks();
        $this->render('_cmanager', compact('tasks', 'success_tasks'));
    }

    public function actionExecuted()
    {
        $task_id = Yii::app()->request->getPost('id');
        $task = $this->loadTask($task_id);

        $url = trim(Yii::app()->request->getPost('url'));
        if (!empty($url)) {
            preg_match("/\/([\d]+)\/$/", $url, $match);
            $article_id = $match[1];
            $article = CommunityContent::model()->findByPk($article_id);
            if ($article === null)
                throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

            $article_keywords = new ArticleKeywords();
            $article_keywords->entity = 'CommunityContent';
            $article_keywords->entity_id = $article_id;
            $article_keywords->keyword_group_id = $task->keyword_group_id;
            $article_keywords->url = $url;
            $article_keywords->save();

            $task->article_id = $article_keywords->id;
            $task->article_title = $article->title;
            if ($task->status != SeoTask::STATUS_TAKEN)
                Yii::app()->end();

            $task->status = SeoTask::STATUS_PUBLISHED;
        } else {
            $task->status = SeoTask::STATUS_WRITTEN;
        }

        echo CJSON::encode(array('status' => $task->save()));
    }

    public function actionTake()
    {
        $task_id = Yii::app()->request->getPost('id');
        $task = $this->loadTask($task_id);
        if ($task->status != SeoTask::STATUS_READY) {
            echo CJSON::encode(array(
                'status' => false,
                'error' => 'задание уже забито'
            ));
            Yii::app()->end();
        }

        $task->executor_id = Yii::app()->user->id;
        $task->status = SeoTask::STATUS_TAKEN;
        if ($task->save()) {
            echo CJSON::encode(array('status' => true));

            $comet = new CometModel();
            $comet->type = CometModel::SEO_TASK_TAKEN;
            $comet->attributes = array('task_id' => $task->id);
            $comet->sendToSeoUsers();
        }
        else
            echo CJSON::encode(array('status' => false));
    }

    public function actionPublish()
    {
        if (!Yii::app()->user->checkAccess('editor'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $task_id = Yii::app()->request->getPost('id');
        $task = $this->loadTask($task_id);
        if ($task->status == SeoTask::STATUS_WRITTEN && $task->type == SeoTask::TYPE_EDITOR) {
            $task->status = SeoTask::STATUS_PUBLICATION;
            echo CJSON::encode(array('status' => $task->save()));
        }
        else
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
