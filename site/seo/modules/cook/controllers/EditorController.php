<?php
/**
 * Author: alexk984
 * Date: 02.04.12
 */
class EditorController extends SController
{
    public $pageTitle = 'Кулинария';
    public $layout = '//layouts/cook';
    public $icon = 2;
    public $section = 2;

    public function beforeAction($action)
    {
        if (!Yii::app()->user->checkAccess('cook-manager-panel'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        if (isset($_GET['section']) && $_GET['section'] == 3)
            $this->pageTitle = 'Рукоделие';
        if (isset($_GET['section']) && $_GET['section'] == 4)
            $this->pageTitle = 'Интерьеры';

        return true;
    }

    public function actionIndex($section = 2)
    {
        $model = new Keyword;
        $model->attributes = $_GET;

        $this->render('index', array(
            'model' => $model,
            'theme' => $section,
        ));
    }

    public function actionName($section)
    {
        $model = new Keyword;
        $tasks = SeoTask::getTasksByName($section);
        $this->render('by_name', compact('tasks', 'model', 'section'));
    }

    public function actionAddByName()
    {
        $urls = Yii::app()->request->getPost('urls');
        $title = Yii::app()->request->getPost('title');
        $section = Yii::app()->request->getPost('section');

        if (!empty($title)) {
            $task = new SeoTask('cook');
            $task->article_title = $title;
            $task->status = SeoTask::STATUS_NEW;
            $task->owner_id = Yii::app()->user->id;
            $task->section = $section;
            if ($task->save())
                foreach ($urls as $url)
                    if (!empty($url)) {
                        $task_url = new TaskUrl();
                        $task_url->url = $url;
                        $task_url->task_id = $task->id;
                        $task_url->save();
                    }
            echo CJSON::encode(array(
                'status' => true,
                'title' => $task->article_title
            ));
        } else
            echo CJSON::encode(array('status' => false));

    }

    public function actionTasks($section)
    {
        $this->section = $section;
        TempKeyword::filterBusyKeywords();
        $tempKeywords = TempKeyword::model()->findAll('owner_id=' . Yii::app()->user->id . ' AND section = ' . $section);

        $by_name_tasks = SeoTask::getTasksByName($section);
        $tasks = SeoTask::getNewTasks($section);
        $authors = Yii::app()->user->model->getWorkers('cook-author');

        $this->render('tasks', compact('by_name_tasks', 'tasks', 'tempKeywords', 'section', 'authors'));
    }

    public function actionAddTask()
    {
        $key_id = Yii::app()->request->getPost('key_id');
        $task_id = Yii::app()->request->getPost('task_id');
        $urls = Yii::app()->request->getPost('urls');
        $author_id = Yii::app()->request->getPost('author_id');
        $section = Yii::app()->request->getPost('section');

        if (empty($task_id)) {
            $keyword = Keyword::model()->findByPk($key_id);
            if (!empty($keyword->group)) {
                $response = array(
                    'status' => false,
                    'error' => 'Ошибка, ключевое слово ' . $keyword->name . ' уже использовалось'
                );
                echo CJSON::encode($response);
                Yii::app()->end();
            }

            if (empty($keyword)) {
                $response = array(
                    'status' => false,
                    'error' => 'Ошибка, вы не выбрали ключевые слова'
                );
                echo CJSON::encode($response);
                Yii::app()->end();
            }

            $group = new KeywordGroup();
            $group->keywords = array($keyword);

            if ($group->withRelated->save(true, array('keywords'))) {
                $task = new SeoTask();
                $task->keyword_group_id = $group->id;
                $task->executor_id = $author_id;
                $task->owner_id = Yii::app()->user->id;
                $task->section = $section;
                $task->multivarka = Yii::app()->request->getPost('multivarka');

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
                        'html' => $this->renderPartial('_task2', array('task' => $task), true)
                    );
                } else
                    $response = array('status' => false);
            } else
                $response = array('status' => false);
        } else {
            $task = SeoTask::model()->findByPk($task_id);
            $task->scenario = 'cook';
            $task->executor_id = $author_id;
            $task->multivarka = Yii::app()->request->getPost('multivarka');

            if ($task->save()) {
                foreach ($task->urls as $url)
                    $url->delete();

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
                    'html' => $this->renderPartial('_task2', array('task' => $task), true)
                );
            } else
                $response = array('status' => false, 'error' => $task->getErrors());
        }

        echo CJSON::encode($response);
    }

    public function actionReturnTask()
    {
        $task = $this->loadTask(Yii::app()->request->getPost('id'));
        $authors = Yii::app()->user->model->getWorkers('cook-author');
        $this->section = $task->section;

        if (isset($task->keywordGroup)) {
            $group = $task->keywordGroup;
            $keywords = $task->keywordGroup->keywords;
            $task->delete();
            $group->delete();
            $response = array(
                'status' => true,
                'html' => $this->renderPartial('_task1', array('type' => 1, 'keyword' => $keywords[0], 'authors' => $authors), true)
            );
        } else {
            $task->executor_id = null;
            $task->multivarka = null;
            $task->save();
            $response = array(
                'status' => true,
                'html' => $this->renderPartial('_task1', array('type' => 2, 'by_name_task' => $task, 'authors' => $authors), true)
            );
        }

        echo CJSON::encode($response);
    }

    public function actionReports($section, $status = 1)
    {
        $criteria = SeoTask::getReportsCriteria($status, $section);

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
            'tasks' => $models,
            'pages' => $pages,
            'status' => $status,
            'section' => $section
        ));
    }

    public function actionChangeSection()
    {
        $task_id = Yii::app()->request->getPost('task_id');
        $task = $this->loadTask($task_id);
        $task->section = Yii::app()->request->getPost('section');
        ;
        echo CJSON::encode(array('status' => $task->save()));
    }

    /*public function actionPopular()
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 'entity = "CookRecipe" OR entity = "CookContent"';
        $criteria->order = 'yandex_month_visits desc';
        $criteria->limit = 500;

        $models = Page::model()->findAll($criteria);
        foreach($models as $model)
            echo $model->url."<br>";
    }*/

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
