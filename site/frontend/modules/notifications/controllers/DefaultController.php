<?php

class DefaultController extends HController
{
    public function filters()
    {
        return array(
            'ajaxOnly + readOne,readAll,unread',
        );
    }

    public function init()
    {
        Yii::import('site.frontend.modules.routes.models.*');
        parent::init();
    }

    public function actionIndex($page = 0)
    {
        $this->pageTitle = 'Новые уведомления';
        $list = Notification::model()->getNotificationsList(Yii::app()->user->id, 0, $page);
        NotificationRead::setReadLikes($list);

        if (Yii::app()->request->isAjaxRequest)
            $this->renderPartial('list', array('list' => $list, 'check' => true));
        else
            $this->render('index', compact('list'));
    }

    public function actionRead($page = 0)
    {
        $this->pageTitle = 'Прочитанные уведомления';

        $list = Notification::model()->getNotificationsList(Yii::app()->user->id, 1, $page);
        if (Yii::app()->request->isAjaxRequest)
            $this->renderPartial('list', array('list' => $list, 'check' => false));
        else
            $this->render('read', compact('list'));
    }

    public function actionReadOne()
    {
        $id = Yii::app()->request->getPost('id');
        $model = Notification::model()->findByPk($id);
        if (isset($model['_id']))
            Notification::model()->readByPk($model['_id']);
        echo CJSON::encode(array('status' => true));
    }

    public function actionUnread()
    {
        $id = Yii::app()->request->getPost('id');
        $model = Notification::model()->findByPk($id);
        if (isset($model['_id']))
            Notification::model()->unreadByPk($model['_id']);

        echo CJSON::encode(array('status' => true));
    }

    public function actionReadAll()
    {
        Notification::model()->readAll();
        echo CJSON::encode(array('status' => true));
    }
}