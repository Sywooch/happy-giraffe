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
        $criteria = new CDbCriteria;
        $criteria->condition = 'owner_id = :owner_id AND status > ' . SeoTask::STATUS_PUBLICATION;
        $criteria->params = array('owner_id' => Yii::app()->user->getModel()->owner_id);
        $criteria->order = 'created desc';

        $dataProvider = new CActiveDataProvider('SeoTask', array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => 100),
        ));
        $count = SeoTask::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 100;
        $pages->currentPage = Yii::app()->request->getParam('page', 1) - 1;
        $pages->applyLimit($dataProvider->criteria);

        $tasks = SeoTask::model()->findAll($dataProvider->criteria);
        $this->render('_cm_reports', compact('tasks', 'pages'));
    }

    public function actionPublish()
    {

        $task_id = Yii::app()->request->getPost('id');
        $task = $this->loadTask($task_id);
        if ($task->status != SeoTask::STATUS_PUBLICATION)
            Yii::app()->end();

        $url = trim(Yii::app()->request->getPost('url'));

        $page = Page::model()->findByAttributes(array('url' => $url));
        if ($page !== null) {
            list($entity, $entity_id) = Page::ParseUrl($url);
            $recipe = $entity::model()->findByPk($entity_id);

            if ($recipe === null) {
                echo CJSON::encode(array(
                    'status' => false,
                    'error' => 'Статья не найдена 1'
                ));
                Yii::app()->end();
            }
        } else {
            list($entity, $entity_id) = Page::ParseUrl($url);
            $recipe = $entity::model()->findByPk($entity_id);

            if ($recipe === null) {
                echo CJSON::encode(array(
                    'status' => false,
                    'error' => 'Статья не найдена 2',
                    'entity' => $entity,
                    'entity_id' => $entity_id,
                ));
                Yii::app()->end();
            }

            $page = new Page();
        }

        if ($entity == 'CookRecipe' && $recipe->section != $task->multivarka) {
            echo CJSON::encode(array(
                'status' => false,
                'error' => 'Вы разместили рецепт не в тот раздел. ' . ($task->multivarka ? ' Нужен раздел мультиварка' : ' Нужен обычный раздел а не мультиварка')
            ));
            Yii::app()->end();
        }

        $page->entity = $entity;
        $page->entity_id = $entity_id;
        if (!empty($task->keyword_group_id))
            $page->keyword_group_id = $task->keyword_group_id;
        else {
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
