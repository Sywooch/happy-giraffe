<?php
/**
 * Author: alexk984
 * Date: 02.04.12
 */
class TaskController extends SController
{
    public function actionIndex()
    {
        $model = new Keywords('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Keywords']))
            $model->attributes = $_GET['Keywords'];
        if (empty($model->name))
            $model->name = 'поисковый запрос';

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionTasks()
    {
        $tasks = SeoTask::model()->findAll('owner_id=' . Yii::app()->user->id . ' AND status < 5 AND rewrite = 0');
        $tempKeywords = TempKeywords::model()->findAll('owner_id');
        $success_tasks = SeoTask::TodayExecutedTasks();

        $this->render('editor_panel', array(
            'tasks' => $tasks,
            'tempKeywords' => $tempKeywords,
            'success_tasks' => $success_tasks
        ));
    }

    public function actionRewriteTasks()
    {
        $tasks = SeoTask::model()->findAll('owner_id=' . Yii::app()->user->id . ' AND status < 5 AND rewrite = 1');
        $tempKeywords = TempKeywords::model()->findAll('owner_id');
        $success_tasks = SeoTask::TodayExecutedTasks();

        $this->render('rewrite_editor_panel', array(
            'tasks' => $tasks,
            'tempKeywords' => $tempKeywords,
            'success_tasks' => $success_tasks
        ));
    }

    public function actionArticles()
    {
        $this->render('articles');
    }

    public function actionSearchKeywords()
    {
        $term = $_POST['term'];
        if (!empty($term)) {

            $allSearch = $textSearch = Yii::app()->search
                ->select('*')
                ->from('keywords')
                ->where('*' . $term . '*')
                ->limit(0, 1000)
                ->searchRaw();
            $ids = array();
            foreach ($allSearch['matches'] as $key => $m) {
                $ids [] = $key;
            }

            if (!empty($ids)) {
                $criteria = new CDbCriteria;
                $criteria->compare('id', $ids);
                //$criteria->with = array('keywordGroups', 'keywordGroups.newTaskCount', 'keywordGroups.articleKeywords');
                $models = Keywords::model()->findAll($criteria);
            } else
                $models = array();
            $this->renderPartial('_keywords', array('models' => $models));
        }
    }

    public function actionSelectKeyword()
    {
        $key_id = Yii::app()->request->getPost('id');
        $temp = new TempKeywords;
        $temp->keyword_id = $key_id;
        $temp->owner_id = Yii::app()->user->id;
        echo CJSON::encode(array('status' => $temp->save()));
    }

    public function actionAddGroupTask()
    {
        $key_ids = Yii::app()->request->getPost('id');
        $type = Yii::app()->request->getPost('type');
        $rewrite = Yii::app()->request->getPost('rewrite');
        $urls = Yii::app()->request->getPost('urls');

        $author_id = Yii::app()->request->getPost('author_id');
        $keywords = Keywords::model()->findAllByPk($key_ids);

        $group = new KeywordGroup();
        $group->keywords = $keywords;
        if ($group->save()) {
            $task = new SeoTask();
            $task->keyword_group_id = $group->id;
            $task->type = $type;
            $task->status = SeoTask::STATUS_NEW;
            $task->owner_id = Yii::app()->user->id;

            if ($type == SeoTask::TYPE_EDITOR)
                $task->executor_id = $author_id;
            if ($rewrite)
                $task->rewrite = 1;

            $response = array('status' => $task->save());
            if (!empty($urls) && $response['status']){
                foreach($urls as $url){
                    $r_url = new RewriteUrl();
                    $r_url->task_id = $task->id;
                    $r_url->url = $url;
                    $r_url->save();
                }
            }
        } else
            $response = array('status' => false);

        echo CJSON::encode($response);
    }

    public function actionGetArticleInfo()
    {
        $url = Yii::app()->request->getPost('url');
        preg_match("/\/([\d]+)\/$/", $url, $match);
        $id = $match[1];

        if (strstr($url, '/community/')) {
            $article = CommunityContent::model()->findByPk($id);
            if (!$article) {
                echo CJSON::encode(array(
                    'status' => false,
                    'error' => 'Ошибка, статья не найдена'
                ));
                Yii::app()->end();
            }

            echo CJSON::encode(array(
                'status' => true,
                'title' => $article->title,
                'keywords' => $article->meta_keywords,
                'id' => $article->id
            ));
        }
    }

    public function actionSaveArticleKeys()
    {
        $id = Yii::app()->request->getPost('id');
        $keywords = Yii::app()->request->getPost('keywords');

        $article = CommunityContent::model()->findByPk($id);
        $article_keywords = new ArticleKeywords();
        $article_keywords->entity = 'CommunityContent';
        $article_keywords->entity_id = $article->id;

        $group = new KeywordGroup();
        $keywords = array();

        foreach ($keywords as $keyword) {
            $keyword = trim($keyword);
            if (!empty($keyword)) {
                $model = Keywords::model()->findByAttributes(array('name' => $keyword));
                if ($model === null)
                    throw new CHttpException(401, 'кейворд не найден в базе');
                $keywords[] = $model;
            }
        }

        if (empty($keywords))
            throw new CHttpException(401, 'нет ни одного кейворда');

        $group->keywords = $keywords;
        $group->save();

        $article_keywords->keyword_group_id = $group->id;

        if ($article_keywords->save()) {
            $response = array(
                'status' => true
            );
        } else {
            $response = array(
                'status' => false,
            );
        }

        echo CJSON::encode($response);
    }

    public function actionModerator()
    {
        if (!Yii::app()->user->checkAccess('moderator'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $tasks = SeoTask::getTasks();
        $executing = SeoTask::getActiveTask();
        $success_tasks = SeoTask::TodayExecutedTasks();

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

        $task->executed = date("Y-m-d H:i:s");
        $url = Yii::app()->request->getPost('url');
        if (!empty($url)) {
            preg_match("/\/([\d]+)\/$/", $url, $match);
            $article_id = $match[1];
            $article = CommunityContent::model()->findByPk($article_id);
            if ($article === null)
                throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

            $task->article_id = $article_id;
            if ($task->status != SeoTask::STATUS_CHECKED && $task->status != SeoTask::STATUS_TAKEN)
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
        if ($task->status != SeoTask::STATUS_NEW) {
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

    public function actionClose()
    {
        if (!Yii::app()->user->checkAccess('editor'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $task_id = Yii::app()->request->getPost('id');
        $task = $this->loadTask($task_id);
        if ($task->status == SeoTask::STATUS_PUBLISHED) {
            $task->status = SeoTask::STATUS_CLOSED;
            echo CJSON::encode(array('status' => $task->save()));
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
            $task->status = SeoTask::STATUS_CHECKED;
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
