<?php

class DefaultController extends HController
{
    public function filters()
    {
        return array(
            'ajaxOnly + read,readAll',
        );
    }

    public function actionIndex()
    {
        $list = Notification::model()->getNotificationsList(Yii::app()->user->id);
        $this->render('index', compact('list'));
    }

    public function actionRead()
    {
        $id = Yii::app()->request->getPost('id');
        $model = Notification::model()->findByPk($id);
        if (isset($model['_id']))
            Notification::model()->readByPk($model['_id']);
    }

    public function actionReadAll()
    {
        Notification::model()->readAll();
    }
}