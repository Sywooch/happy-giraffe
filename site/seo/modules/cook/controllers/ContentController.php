<?php
/**
 * Author: alexk984
 * Date: 02.04.12
 */
class ContentController extends SController
{
    public $layout = '//layouts/cook';
    public $icon = 2;

    public function beforeAction($action)
    {
        if (!Yii::app()->user->checkAccess('cook-content-manager'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $this->pageTitle = 'контент';
        return true;
    }

    public function actionIndex()
    {
        $tasks = SeoTask::getTasks();
        $this->render('_cm', compact('tasks'));
    }

    public function actionReports()
    {
        $tasks = SeoTask::TodayExecutedTasks();
        $this->render('_cm_reports', compact('tasks'));
    }

    public function actionPublish(){

        $task_id = Yii::app()->request->getPost('id');
        $task = $this->loadTask($task_id);
        if ($task->status != SeoTask::STATUS_PUBLICATION)
            Yii::app()->end();

        Yii::import('site.frontend.modules.cook.models.*');

        $url = trim(Yii::app()->request->getPost('url'));

        $page = Page::model()->findByAttributes(array('url' => $url));
        if ($page !== null) {
            $recipe = CookRecipe::model()->findByPk($page->entity_id);

            if ($recipe === null) {
                echo CJSON::encode(array(
                    'status' => false,
                    'error' => 'Статья не найдена'
                ));
                Yii::app()->end();
            }

            if (!$page->save()) {
                echo CJSON::encode(array(
                    'status' => false,
                    'error' => 'Ошибка сохранения статьи',
                    'errorText' => $page->getErrors()
                ));
                Yii::app()->end();
            }
        } else {
            preg_match("/([\d]+)\/$/", $url, $match);
            if (!isset($match[1])) {
                echo CJSON::encode(array(
                    'status' => false,
                    'error' => 'Статья не найдена'
                ));
                Yii::app()->end();
            }

            $recipe_id = $match[1];
            $recipe = CookRecipe::model()->findByPk($recipe_id);
            if ($recipe === null) {
                echo CJSON::encode(array(
                    'status' => false,
                    'error' => 'Статья не найдена'
                ));
                Yii::app()->end();
            }

            $page = new Page();
        }

        if ($recipe->section != $task->multivarka){
            echo CJSON::encode(array(
                'status' => false,
                'error' => 'Вы разместили рецепт не в тот раздел. '.($task->multivarka?' Нужен раздел мультиварка':' Нужен обычный раздел а не мультиварка')
            ));
            Yii::app()->end();
        }

        $page->entity = 'CookRecipe';
        $page->entity_id = $recipe->id;
        if (!empty($task->keyword_group_id))
            $page->keyword_group_id = $task->keyword_group_id;
        else{
            $group = new KeywordGroup();
            $group->save();
            $page->keyword_group_id = $group->id;
        }

        $page->url = $url;

        if (!$page->save()) {
            echo CJSON::encode(array(
                'status' => false,
                'error' => 'Ошибка сохранения статьи',
                'errorText' => $page->getErrors()
            ));
            Yii::app()->end();
        }

        $task->status = SeoTask::STATUS_PUBLISHED;
        $task->article_id = $page->id;
        echo CJSON::encode(array('status' => $task->save()));
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
