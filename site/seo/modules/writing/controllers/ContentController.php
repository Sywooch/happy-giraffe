<?php
/**
 * Author: alexk984
 * Date: 02.04.12
 */
class ContentController extends SController
{
    public $layout = '//layouts/writing';

    public function beforeAction($action)
    {
        if (!Yii::app()->user->checkAccess('content-manager'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $this->pageTitle = 'контент-менеджер';
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
}
