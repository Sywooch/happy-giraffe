<?php
/**
 * Author: alexk984
 * Date: 02.04.12
 */
class TaskController extends SController
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

    public function actionAuthor()
    {
        if (!Yii::app()->user->checkAccess('author'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $this->pageTitle = 'автор';
        $tasks = SeoTask::getTasks();
        $executing = SeoTask::getActiveTask();

        $this->render('_author', compact('tasks', 'executing'));
    }

    public function actionAuthorReports()
    {
        if (!Yii::app()->user->checkAccess('author'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $this->pageTitle = 'автор';
        $tasks = SeoTask::TodayExecutedTasks();
        $this->render('_author_reports', compact('tasks'));
    }

    public function actionCorrector()
    {
        if (!Yii::app()->user->checkAccess('corrector'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        $this->pageTitle = 'корректор';

        $tasks = SeoTask::getTasks();
        $executing = SeoTask::getActiveTask();

        $this->render('_corrector', compact('tasks', 'executing'));
    }

    public function actionCorrectorReports()
    {
        if (!Yii::app()->user->checkAccess('corrector'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $this->pageTitle = 'корректор';
        $tasks = SeoTask::TodayExecutedTasks();
        $this->render('_corrector_reports', compact('tasks'));
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

    public function actionExecuted()
    {
        $task_id = Yii::app()->request->getPost('id');
        $task = $this->loadTask($task_id);

        $url = trim(Yii::app()->request->getPost('url'));
        if (!empty($url)) {
            preg_match("/([\d]+)\/$/", $url, $match);
            if (!isset($match[1])) {
                echo CJSON::encode(array(
                    'status' => false,
                    'error' => 'Статья не найдена'
                ));
                Yii::app()->end();
            }

            $article_id = $match[1];
            $article = CommunityContent::model()->findByPk($article_id);
            if ($article === null) {
                echo CJSON::encode(array(
                    'status' => false,
                    'error' => 'Статья не найдена'
                ));
                Yii::app()->end();
            }

            $article_keywords = new Page();
            if ($article->getIsFromBlog())
                $article_keywords->entity = 'BlogContent';
            else
                $article_keywords->entity = 'CommunityContent';
            $article_keywords->entity_id = $article_id;
            $article_keywords->keyword_group_id = $task->keyword_group_id;
            $article_keywords->url = $url;
            if (!$article_keywords->save()) {
                $errorText = '';
                foreach ($article_keywords->getErrors() as $error) {
                    foreach ($error as $errorPart)
                        $errorText .= $errorPart . ' ';
                }

                echo CJSON::encode(array(
                    'status' => false,
                    'error' => 'Ошибка сохранения статьи',
                    'errorText' => $errorText
                ));
                Yii::app()->end();
            }

            $task->article_id = $article_keywords->id;
            if (empty($task->article_title))
                $task->article_title = $article->title;

            if ($task->status != SeoTask::STATUS_TAKEN && $task->status != SeoTask::STATUS_PUBLICATION)
                Yii::app()->end();

            $task->status = SeoTask::STATUS_PUBLISHED;
        } else {
            if ($task->type == SeoTask::TYPE_EDITOR)
                $task->status = SeoTask::STATUS_WRITTEN;
            else {
                echo CJSON::encode(array(
                    'status' => false,
                    'error' => 'Не ввели url статьи'
                ));
                Yii::app()->end();
            }
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

            if ($task->type == SeoTask::TYPE_MODER) {
                $comet = new CometModel();
                $comet->type = CometModel::SEO_TASK_TAKEN;
                $comet->attributes = array('task_id' => $task->id);
                $comet->sendToSeoUsers();
            }
        } else
            echo CJSON::encode(array('status' => false));
    }

    public function actionCorrected()
    {
        if (!Yii::app()->user->checkAccess('corrector'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

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
