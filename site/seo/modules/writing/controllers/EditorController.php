<?php
/**
 * Author: alexk984
 * Date: 02.04.12
 */
class EditorController extends SController
{
    public $pageTitle = 'Копирайт';
    public $layout = '//layouts/writing';

    public function beforeAction($action)
    {
        if (!Yii::app()->user->checkAccess('admin') && !Yii::app()->user->checkAccess('editor')
            && !Yii::app()->user->checkAccess('superuser')
        )
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return true;
    }

    public function actionIndex()
    {
        $model = new Keyword();
        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function actionSearchKeywords()
    {
        $term = $_POST['term'];
        if (!empty($term)) {
            $model = new Keyword;
            $model->name = $term;

            $dataProvider = $model->search();
            $criteria = $dataProvider->criteria;
            $count = Keyword::model()->count($dataProvider->criteria);
            $pages = new CPagination($count);
            $pages->pageSize = 100;
            $pages->currentPage = Yii::app()->request->getPost('page');
            $pages->applyLimit($dataProvider->criteria);

            $counts = Keyword::model()->getFreqCount($criteria);
            $criteria2 = clone $criteria;
            $criteria2->with = array('yandex', 'pastuhovYandex', 'seoStats', 'group', 'tempKeyword');
            $models = Keyword::model()->findAll($criteria2);
            $response = array(
                'status' => true,
                'count' => $this->renderPartial('_find_result_count', compact('models', 'counts'), true),
                'table' => $this->renderPartial('_find_result_table', compact('models'), true),
                'pagination' => $this->renderPartial('_find_result_pagination', compact('pages'), true)
            );
            echo CJSON::encode($response);
        }
    }

    public function actionHideUsed()
    {
        $checked = Yii::app()->request->getPost('checked');
        if (!empty($checked)) {
            Yii::app()->user->setState('hide_used', 1);
        } else
            Yii::app()->user->setState('hide_used', 0);
    }

    public function actionTasks()
    {
        $tempKeywords = TempKeyword::model()->findAll('owner_id=' . Yii::app()->user->id);
        foreach ($tempKeywords as $tempKeyword) {
            if (!empty($tempKeyword->keyword->group)) {
                $success = false;
                foreach ($tempKeyword->keyword->group as $group)
                    if (empty($group->seoTasks) && empty($group->page))
                        $success = $group->delete();

                if (!$success)
                    $tempKeyword->delete();
            }
        }
        $tempKeywords = TempKeyword::model()->findAll('owner_id=' . Yii::app()->user->id);

        $criteria = new CDbCriteria;
        $criteria->condition = 'owner_id=' . Yii::app()->user->id . ' AND status = 0';
        $criteria->order = 'created desc';
        $tasks = SeoTask::model()->findAll();

        $this->render('editor_panel', array(
            'tasks' => $tasks,
            'tempKeywords' => $tempKeywords,
        ));
    }

    public function actionRewriteTasks()
    {
        $tasks = SeoTask::model()->findAll('owner_id=' . Yii::app()->user->id . ' AND status < 5 AND rewrite = 1');
        $tempKeywords = TempKeyword::model()->findAll('owner_id');
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
        $keyword = Keyword::model()->findByPk($key_id);
        if (!TempKeyword::model()->exists('keyword_id=' . $key_id) && $keyword !== null) {
            $temp = new TempKeyword;
            //remove duplicates
            $duplicates = Keyword::model()->findAllByAttributes(array('name' => $keyword->name));
            if (count($duplicates) > 1) {
                foreach ($duplicates as $duplicate)
                    if ($duplicate->id != $key_id)
                        $duplicate->delete();
            }
            $temp->keyword_id = $key_id;
            $temp->owner_id = Yii::app()->user->id;
            echo CJSON::encode(array('status' => $temp->save()));
        } else
            echo CJSON::encode(array('status' => false));
    }

    public function actionCancelSelectKeyword()
    {
        $key_id = Yii::app()->request->getPost('id');
        TempKeyword::model()->deleteByPk($key_id);
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
        $keywords = Keyword::model()->findAllByPk($key_ids);

        foreach ($keywords as $keyword)
            if (!empty($keyword->group)) {
                $response = array(
                    'status' => false,
                    'error' => 'Ошибка, ключевое слово ' . $keyword->id . ' уже использовалось'
                );
                echo CJSON::encode($response);
                Yii::app()->end();
            }

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
            } else
                $response = array('status' => false);
        } else
            $response = array('status' => false);

        echo CJSON::encode($response);
    }

    public function actionRemoveFromSelected()
    {
        $key_id = Yii::app()->request->getPost('id');
        TempKeyword::model()->deleteByPk($key_id);
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
                TempKeyword::model()->deleteAll('keyword_id=' . $keyword->id);
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
        } else
            echo CJSON::encode(array('status' => false));
    }

    public function actionCorrection()
    {
        $task_id = Yii::app()->request->getPost('id');
        $task = $this->loadTask($task_id);

        if ($task->status == SeoTask::STATUS_WRITTEN) {
            $task->status = SeoTask::STATUS_CORRECTING;
            echo CJSON::encode(array(
                'status' => $task->save(),
                'html' => $this->renderPartial('_correcting_task', compact('task'), true)
            ));
        } else
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
        } else
            echo CJSON::encode(array('status' => false));
    }

    public function actionBindKeywordToArticle()
    {
        $keyword_id = Yii::app()->request->getPost('keyword_id');
        $article_id = Yii::app()->request->getPost('article_id');

        $article = Page::model()->findByAttributes(array(
            'entity_id' => $article_id
        ));
        if ($article !== null) {
            $keyword_ids = array();
            foreach ($article->keywordGroup->keywords as $keyword) {
                if ($keyword->id == $keyword_id) {
                    echo CJSON::encode(array(
                        'status' => false,
                        'error' => 'Уже привязан'
                    ));
                    Yii::app()->end();
                }
                $keyword_ids [] = $keyword->id;
            }
            $keyword_ids[] = $keyword_id;
            $article->keywordGroup->keywords = $keyword_ids;
            if (!$article->keywordGroup->save()) {
                echo CJSON::encode(array(
                    'status' => false,
                    'error' => 'Ошибка при сохранении группы кейвордов'
                ));
                Yii::app()->end();
            }
        } else {
            $model = CommunityContent::model()->findByPk($article_id);
            if ($model === null){
                echo CJSON::encode(array(
                    'status' => false,
                    'error' => 'Статья не найдена'
                ));
                Yii::app()->end();
            }
            $article_keywords = new Page();
            $article_keywords->entity = 'CommunityContent';
            $article_keywords->entity_id = $article_id;
            $article_keywords->url = 'http://www.happy-giraffe.ru'.$model->getUrl();

            $group = new KeywordGroup();
            $group->keywords = array($keyword_id);
            if (!$group->save()) {
                echo CJSON::encode(array(
                    'status' => false,
                    'error' => 'Ошибка при сохранении группы кейвордов'
                ));
                Yii::app()->end();
            }
            $article_keywords->keyword_group_id = $group->id;
            if (!$article_keywords->save()){
                echo CJSON::encode(array(
                    'status' => false,
                    'error' => 'Ошибка при сохранении статьи '
                ));
                $group->delete();
                Yii::app()->end();
            }
        }

        echo CJSON::encode(array('status' => true));
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
