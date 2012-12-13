<?php
/**
 * Author: alexk984
 * Date: 02.04.12
 */
class EditorController extends SController
{
    public $pageTitle = 'Копирайт';
    public $layout = '//layouts/writing';
    public $rewrite = 0;

    public function beforeAction($action)
    {
        if (!Yii::app()->user->checkAccess('admin') && !Yii::app()->user->checkAccess('editor')
            && !Yii::app()->user->checkAccess('superuser') && !Yii::app()->user->checkAccess('cook-manager-panel')
        )
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        if (isset($_GET['rewrite'])) {
            $this->rewrite = $_GET['rewrite'];
            Yii::app()->user->setState('rewrite', $this->rewrite);
        }

        $this->rewrite = Yii::app()->user->getState('rewrite', 0);
        if ($this->rewrite == 1)
            $this->pageTitle = 'Рерайт';

        return true;
    }

    public function actionIndex($theme = 0)
    {
        $model = new Keyword();
        $model->attributes = $_GET;

        $this->render('index', array(
            'model' => $model,
            'theme' => $theme,
        ));
    }

    public function actionHideUsed()
    {
        $checked = Yii::app()->request->getPost('checked');
        if (!empty($checked)) {
            Yii::app()->user->setState('hide_used', 1);
        } else
            Yii::app()->user->setState('hide_used', 0);
    }

    public function actionTasks($rewrite = 0)
    {
        TempKeyword::filterBusyKeywords();
        $tempKeywords = TempKeyword::model()->findAll('owner_id=' . Yii::app()->user->id);

        $criteria = new CDbCriteria;
        $criteria->condition = 'owner_id=' . Yii::app()->user->id . ' AND status = 0';
        $criteria->condition .= ($this->rewrite == 0) ? ' AND rewrite = 0' : ' AND rewrite = 1';
        $criteria->order = 'created desc';
        $tasks = SeoTask::model()->findAll($criteria);

        if ($this->rewrite)
            $authors = Yii::app()->user->model->getWorkers('rewrite-author');
        else
            $authors = Yii::app()->user->model->getWorkers('author');

        $this->render(($this->rewrite == 0) ? 'editor_panel' : 'rewrite_editor_panel', array(
            'tasks' => $tasks,
            'tempKeywords' => $tempKeywords,
            'authors' => $authors
        ));
    }

    public function actionSelectKeyword()
    {
        $key_id = Yii::app()->request->getPost('id');
        $section = Yii::app()->request->getPost('section');
        $keyword = Keyword::model()->findByPk($key_id);

        if (!TempKeyword::model()->exists('keyword_id=' . $key_id) && $keyword !== null) {
            $temp = new TempKeyword;
            $temp->keyword_id = $key_id;
            $temp->owner_id = Yii::app()->user->id;
            if (!empty($section))
                $temp->section = $section;

            echo CJSON::encode(array('status' => $temp->save(), 'inc' => true));
        } else
            echo CJSON::encode(array(
                'status' => false,
                'error' => 'Уже в работе, обновите страницу'
            ));
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
        $keywords = Keyword::model()->with('group')->findAllByPk($key_ids);

        foreach ($keywords as $keyword)
            if (!empty($keyword->group)) {
                $response = array(
                    'status' => false,
                    'error' => 'Ошибка, ключевое слово ' . $keyword->id . ' уже использовалось'
                );
                echo CJSON::encode($response);
                Yii::app()->end();
            }

        if (empty($keywords)) {
            $response = array(
                'status' => false,
                'error' => 'Ошибка, вы не выбрали ключевые слова'
            );
            echo CJSON::encode($response);
            Yii::app()->end();
        }

        $group = new KeywordGroup();
        $group->keywords = $keywords;
        if ($group->withRelated->save(true, array('keywords'))) {
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
                        $r_url = new TaskUrl();
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
        if (isset($task->keywordGroup)) {
            $group = $task->keywordGroup;
            $keywords = $task->keywordGroup->keywords;
        }
        $task->delete();
        if (isset($group))
            $group->delete();

        $keys = array();
        if (isset($keywords))
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
        $section = Yii::app()->request->getPost('section');
        $task = $this->loadTask($id);
        $task->status = SeoTask::STATUS_READY;
        if (!empty($section))
            $task->section = $section;

        echo CJSON::encode(array('status' => $task->save()));
    }

    public function actionReports($status = 1)
    {
        $criteria = SeoTask::getReportsCriteria($status, SeoTask::SECTION_MAIN, $this->rewrite);

        $dataProvider = new CActiveDataProvider('SeoTask', array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => 100),
        ));
        $count = SeoTask::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 100;
        $pages->currentPage = Yii::app()->request->getParam('page', 1) - 1;
        $pages->applyLimit($dataProvider->criteria);

        $dataProvider->criteria->with = array('executor', 'article', 'keywordGroup');
        $models = SeoTask::model()->findAll($dataProvider->criteria);

        $this->render('reports_' . $status, array(
            'models' => $models,
            'pages' => $pages,
            'status' => $status,
            'rewrite' => $this->rewrite
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
        if (!Yii::app()->user->checkAccess('editor') && !Yii::app()->user->checkAccess('cook-manager-panel'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $task_id = Yii::app()->request->getPost('id');
        $task = $this->loadTask($task_id);
        if ($task->status == SeoTask::STATUS_CORRECTED || $task->status == SeoTask::STATUS_WRITTEN) {
            $task->status = SeoTask::STATUS_PUBLICATION;
            echo CJSON::encode(array('status' => $task->save()));
        } else
            echo CJSON::encode(array('status' => false));
    }

    public function actionBindKeywordToArticle()
    {
        $keyword_id = Yii::app()->request->getPost('keyword_id');
        $article_id = Yii::app()->request->getPost('article_id');
        $section = Yii::app()->request->getPost('section');

        $article = Page::model()->findByAttributes(array(
            'entity_id' => $article_id
        ));
        if ($article !== null) {
            if ($section == 1)
                $class = 'CommunityContent';
            else
                $class = 'CookRecipe';
            if (!empty($article->entity)) {
                $model = $class::model()->findByPk($article_id);
                $article->entity = $class;
                $article->url = 'http://www.happy-giraffe.ru' . $model->url;
                if (!$article->save())
                    var_dump($article->getErrors());
            }

            $keyword_ids = array();
            if (!empty($article->keywordGroup)) {
                $group = $article->keywordGroup;
                foreach ($group->keywords as $keyword) {
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
                $group->keywords = Keyword::model()->findAllByPk($keyword_ids);
            } else {
                $group = new KeywordGroup();
                $group->keywords = Keyword::model()->findAllByPk(array($keyword_id));
            }

            if (!$group->withRelated->save(true, array('keywords'))) {
                echo CJSON::encode(array(
                    'status' => false,
                    'error' => 'Ошибка при сохранении группы кейвордов'
                ));
                Yii::app()->end();
            } else {
                if (empty($article->keywordGroup)) {
                    $article->keyword_group_id = $group->id;
                    $article->save();
                }
            }
        } else {
            if ($section == 1)
                $class = 'CommunityContent';
            else
                $class = 'CookRecipe';

            $model = $class::model()->findByPk($article_id);

            if ($model === null) {
                echo CJSON::encode(array(
                    'status' => false,
                    'error' => 'Статья не найдена'
                ));
                Yii::app()->end();
            }
            $article_keywords = new Page();
            $article_keywords->entity = $class;
            $article_keywords->entity_id = $article_id;
            $article_keywords->url = 'http://www.happy-giraffe.ru' . $model->getUrl();

            $group = new KeywordGroup();
            $group->keywords = Keyword::model()->findAllByPk($keyword_id);
            if (!$group->withRelated->save(true, array('keywords'))) {
                echo CJSON::encode(array(
                    'status' => false,
                    'error' => 'Ошибка при сохранении группы кейвордов'
                ));
                Yii::app()->end();
            }
            $article_keywords->keyword_group_id = $group->id;
            if (!$article_keywords->save()) {
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

    public function actionBindKeyword()
    {
        $url = Yii::app()->request->getPost('url');
        $keyword_id = Yii::app()->request->getPost('keyword');
        $keyword = Keyword::model()->findByPk($keyword_id);

        $exist = Page::model()->findByAttributes(array(
            'url' => $url,
        ));
        if ($exist !== null) {
            $response = array(
                'status' => false,
                'error' => 'Вы уже вводили эту статью.',
            );
        } else {
            $group = new KeywordGroup();
            $group->keywords = array($keyword);

            if ($group->withRelated->save(true, array('keywords'))) {
                $page = new Page();
                $page->url = $url;
                list($entity, $entity_id) = Page::ParseUrl($url);
                if (!empty($entity) && !empty($entity_id)) {
                    $page->entity = $entity;
                    $page->entity_id = $entity_id;
                }
                $page->keyword_group_id = $group->id;
                if ($page->save()) {
                    $response = array(
                        'status' => true,
                        'html' => $keyword->name . ' <a target="_blank" class="icon-article" href="' . $url . '"></a>',
                    );
                } else
                    $response = array(
                        'status' => false,
                        'error' => 'Не удалось сохранить статью, обратитесь к разработчикам.',
                    );
            } else
                $response = array(
                    'status' => false,
                    'error' => 'Не удалось сохранить группу кейвордов, обратитесь к разработчикам.',
                );
        }

        echo CJSON::encode($response);
    }

    public function actionUnbindKeyword()
    {
        $keyword_id = Yii::app()->request->getPost('keyword');
        $keyword = Keyword::model()->findByPk($keyword_id);

        foreach ($keyword->group as $group) {
            if (isset($group->page)) {
                $group->page->keyword_group_id = null;
                $group->page->update(array('keyword_group_id'));
                if ($group->delete()) {
                    $response = array(
                        'status' => true,
                        'html' => $keyword->name
                    );
                } else
                    $response = array('status' => false);

                echo CJSON::encode($response);
            } else {
                $group->delete();
            }
        }
    }

    public function actionChangeSection()
    {
        $keyword_id = Yii::app()->request->getPost('keyword_id');
        $temp_keyword = TempKeyword::model()->find('keyword_id=' . $keyword_id);
        $temp_keyword->owner_id = 83;
        $temp_keyword->section = Yii::app()->request->getPost('section');

        echo CJSON::encode(array('status' => $temp_keyword->save()));
    }

    public function actionRewriteUrl()
    {
        $url = Yii::app()->request->getPost('url');
        $task = $this->loadTask(Yii::app()->request->getPost('task_id'));
        $url_id = Yii::app()->request->getPost('id');

        //delete url if empty
        if (empty($url)) {
            $task_url = TaskUrl::model()->findByPk($url_id);
            if ($task_url !== null)
                $task_url->delete();
            echo CJSON::encode(array('deleted' => true));
            Yii::app()->end();
        }

        //create or update task url
        if (empty($url_id)) {
            $task_url = new TaskUrl;
            $task_url->task_id = $task->id;
        } else
            $task_url = TaskUrl::model()->findByPk($url_id);
        $task_url->url = $url;
        if ($task_url->save()) {
            echo CJSON::encode(array(
                'status' => true,
                'id' => $task_url->id
            ));
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
