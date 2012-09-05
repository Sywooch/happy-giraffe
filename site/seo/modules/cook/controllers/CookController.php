<?php
/**
 * Author: alexk984
 * Date: 02.04.12
 */
class CookController extends SController
{
    public $pageTitle = 'Кулинария';
    public $layout = '/layouts/cook';

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

    public function actionRecipes(){
        $model = new Keyword();
        $this->render('by_name', array(
            'model' => $model,
        ));
    }

    public function actionAddByName()
    {
        $urls = Yii::app()->request->getPost('urls');
        $name = Yii::app()->request->getPost('name');
    }

    public function actionTasks()
    {
        TempKeyword::filterBusyKeywords();
        $tempKeywords = TempKeyword::model()->findAll('owner_id=' . Yii::app()->user->id);

        $criteria = new CDbCriteria;
        $criteria->condition = 'owner_id=' . Yii::app()->user->id . ' AND status = 0';
        $criteria->order = 'created desc';
        $tasks = SeoTask::model()->findAll($criteria);

        $this->render('tasks', array(
            'tasks' => $tasks,
            'tempKeywords' => $tempKeywords,
        ));
    }

    public function actionAddGroupTask()
    {
        $key_ids = Yii::app()->request->getPost('id');
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
        if ($group->save()) {
            $task = new SeoTask();
            $task->keyword_group_id = $group->id;
            $task->type = SeoTask::TYPE_EDITOR;
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
                    'html' => $this->renderPartial('_distrib_task', array('task' => $task), true)
                );
            } else
                $response = array('status' => false);
        } else
            $response = array('status' => false);

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
    public function loadTask($id)
    {
        $model = SeoTask::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }
}
