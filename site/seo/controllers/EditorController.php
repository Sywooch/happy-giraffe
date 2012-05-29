<?php
/**
 * Author: alexk984
 * Date: 02.04.12
 */
class EditorController extends SController
{
    public $pageTitle = 'Копирайт';

    public function beforeAction($action)
    {
        if (!Yii::app()->user->checkAccess('admin') && !Yii::app()->user->checkAccess('editor')
            && !Yii::app()->user->checkAccess('superuser'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return true;
    }

    public function actionIndex()
    {
        $model = new Keywords();
        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function actionSearchKeywords()
    {
        $term = $_POST['term'];
        if (!empty($term)) {

            $allSearch = $textSearch = Yii::app()->search
                ->select('*')
                ->from('keyword')
                ->where('*' . $term . '*')
                ->limit(0, 100000)
                ->searchRaw();
            $ids = array();
            $blacklist = Yii::app()->db->createCommand('select keyword_id from ' . KeywordBlacklist::model()->tableName())->queryColumn();

            foreach ($allSearch['matches'] as $key => $m) {
                if (!in_array($key, $blacklist))
                    $ids [] = $key;
            }

            if (!empty($ids)) {
                $criteria = new CDbCriteria;
                $criteria->compare('t.id', $ids);
                $criteria->with = array('keywordGroups', 'keywordGroups.newTaskCount', 'keywordGroups.articleKeywords', 'seoStats');
                $criteria->order = 'seoStats.sum desc';
                $models = Keywords::model()->findAll($criteria);
            } else
                $models = array();

            $response = array(
                'status' => true,
                'count' => $this->renderPartial('_find_result_count', array('models' => $models), true),
                'table' => $this->renderPartial('_find_result_table', array('models' => $models), true)
            );
            echo CJSON::encode($response);
        }
    }

    public function actionHideUsed()
    {
        $checked = Yii::app()->request->getPost('checked');
        if (!empty($checked)) {
            Yii::app()->user->setState('hide_used', 1);
        }
        else
            Yii::app()->user->setState('hide_used', 0);
    }

    public function actionTasks()
    {
        $tempKeywords = TempKeywords::model()->findAll('owner_id');
        $tasks = SeoTask::model()->findAll('owner_id=' . Yii::app()->user->id . ' AND status = 0');

        $this->render('editor_panel', array(
            'tasks' => $tasks,
            'tempKeywords' => $tempKeywords,
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

    public function actionSelectKeyword()
    {
        $key_id = Yii::app()->request->getPost('id');
        if (!TempKeywords::model()->exists('keyword_id=' . $key_id)) {
            $temp = new TempKeywords;
            $temp->keyword_id = $key_id;
            $temp->owner_id = Yii::app()->user->id;
            echo CJSON::encode(array('status' => $temp->save()));
        } else
            echo CJSON::encode(array('status' => false));
    }

    public function actionCancelSelectKeyword()
    {
        $key_id = Yii::app()->request->getPost('id');
        TempKeywords::model()->deleteByPk($key_id);
        echo CJSON::encode(array('status' => true));
    }

    public function actionHideKey()
    {
        $key_id = Yii::app()->request->getPost('id');
        $key = new KeywordBlacklist();
        $key->keyword_id = $key_id;
        echo CJSON::encode(array('status' => $key->save()));
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
            $task->owner_id = Yii::app()->user->id;

            if ($type == SeoTask::TYPE_EDITOR)
                $task->executor_id = $author_id;
            if ($rewrite)
                $task->rewrite = 1;

            if ($task->save()) {
                if (!empty($urls)) {
                    foreach ($urls as $url) {
                        $r_url = new RewriteUrl();
                        $r_url->task_id = $task->id;
                        $r_url->url = $url;
                        $r_url->save();
                    }
                }
                $response = array(
                    'status' => true,
                    'html' => $this->renderPartial('_distrib_task', array('task' => $task), true)
                );
            }
            else
                $response = array('status' => false);
        } else
            $response = array('status' => false);

        echo CJSON::encode($response);
    }

    /*    public function actionGetArticleInfo()
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
    }*/

    public function actionRemoveFromSelected()
    {
        $key_id = Yii::app()->request->getPost('id');
        TempKeywords::model()->deleteByPk($key_id);
        echo CJSON::encode(array('status' => true));
    }

    public function actionRemoveTask()
    {
        $id = Yii::app()->request->getPost('id');
        $withKeys = Yii::app()->request->getPost('withKeys');
        $task = SeoTask::model()->findByPk($id);
        $group = $task->keywordGroup;
        $keywords = $task->keywordGroup->keywords;
        $task->delete();
        $group->delete();

        $keys = array();
        foreach ($keywords as $keyword) {
            $keys [] = $keyword->id;
            if ($withKeys)
                TempKeywords::model()->deleteAll('keyword_id=' . $keyword->id);
        }

        echo CJSON::encode(array('status' => true, 'keys' => $keys));
    }

    public function actionReady()
    {
        $id = Yii::app()->request->getPost('id');
        $task = $this->loadTask($id);
        $task->status = SeoTask::STATUS_READY;

        echo CJSON::encode(array('status' => $task->save()));
    }

    public function actionReports()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('owner_id', Yii::app()->user->id);
        $criteria->compare('status >', SeoTask::STATUS_NEW);
        $tasks = SeoTask::model()->findAll($criteria);

        $this->render('reports', array(
            'tasks' => $tasks,
        ));
    }

    public function actionClose()
    {
        $task_id = Yii::app()->request->getPost('id');
        $task = $this->loadTask($task_id);
        if ($task->status == SeoTask::STATUS_PUBLISHED) {
            $task->status = SeoTask::STATUS_CLOSED;
            echo CJSON::encode(array(
                'status' => $task->save(),
                'html' => $this->renderPartial('_closed_task', compact('task'), true)
            ));
        }
        else
            echo CJSON::encode(array('status' => false));
    }

    public function actionCorrection(){
        $task_id = Yii::app()->request->getPost('id');
        $task = $this->loadTask($task_id);

        if ($task->status == SeoTask::STATUS_WRITTEN) {
            $task->status = SeoTask::STATUS_CORRECTING;
            echo CJSON::encode(array(
                'status' => $task->save(),
                'html' => $this->renderPartial('_correcting_task', compact('task'), true)
            ));
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
        if ($task->status == SeoTask::STATUS_CORRECTED) {
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
