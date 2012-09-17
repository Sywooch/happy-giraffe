<?php
/**
 * Author: alexk984
 * Date: 02.04.12
 */
class CookController extends SController
{
    public $pageTitle = 'Кулинария';
    public $layout = '//layouts/cook';
    public $icon = 2;

    public function beforeAction($action)
    {
        if (!Yii::app()->user->checkAccess('cook-manager-panel'))
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

    public function actionRecipes()
    {
        $model = new Keyword();
        $tasks = SeoTask::getTasksByName();
        $this->render('by_name', compact('tasks', 'model'));
    }

    public function actionAddByName()
    {
        $urls = Yii::app()->request->getPost('urls');
        $title = Yii::app()->request->getPost('title');

        if (!empty($title)) {
            $task = new SeoTask('cook');
            $task->article_title = $title;
            $task->status = SeoTask::STATUS_NEW;
            $task->owner_id = Yii::app()->user->id;
            $task->section = SeoTask::SECTION_COOK;
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

    public function actionTasks()
    {
        TempKeyword::filterBusyKeywords();
        $tempKeywords = TempKeyword::model()->findAll('owner_id=' . Yii::app()->user->id);

        $by_name_tasks = SeoTask::getTasksByName();
        $tasks = SeoTask::getNewTasks();

        $this->render('tasks', compact('by_name_tasks', 'tasks', 'tempKeywords'));
    }

    public function actionAddTask()
    {
        $key_id = Yii::app()->request->getPost('key_id');
        $task_id = Yii::app()->request->getPost('task_id');
        $urls = Yii::app()->request->getPost('urls');
        $author_id = Yii::app()->request->getPost('author_id');

        if (empty($task_id)) {
            $keyword = Keyword::model()->with('group')->findByPk($key_id);
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
            $group->keywords = $keyword;
            $group->save();


            if ($group->save()) {
                $task = new SeoTask();
                $task->keyword_group_id = $group->id;
                $task->executor_id = $author_id;
                $task->owner_id = Yii::app()->user->id;
                $task->section = SeoTask::SECTION_COOK;
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

    public function actionReturnTask(){
        $task = $this->loadTask(Yii::app()->request->getPost('id'));

        if (isset($task->keywordGroup)){
            $group = $task->keywordGroup;
            $keywords = $task->keywordGroup->keywords;
            $task->delete();
            $group->delete();
            $response = array(
                'status' => true,
                'html' => $this->renderPartial('_task1',array('type'=>1, 'keyword'=>$keywords[0]), true)
            );
        }else{
            $task->executor_id = null;
            $task->multivarka = null;
            $task->save();
            $response = array(
                'status' => true,
                'html' => $this->renderPartial('_task1',array('type'=>2, 'by_name_task'=>$task), true)
            );
        }

        echo CJSON::encode($response);
    }

    public function actionReports()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('owner_id', Yii::app()->user->id);
        $criteria->compare('section', SeoTask::SECTION_COOK);
        $criteria->compare('status >', SeoTask::STATUS_NEW);
        $criteria->order = 'created desc';
        $tasks = SeoTask::model()->findAll($criteria);

        $this->render('reports', array(
            'tasks' => $tasks,
        ));
    }

    /**
     * @param int $id model id
     * @return SeoTask
     * @throws CHttpException
     */
    public       function loadTask($id)
    {
        $model = SeoTask::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }
}
