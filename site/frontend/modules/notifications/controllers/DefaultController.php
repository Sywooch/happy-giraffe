<?php

class DefaultController extends HController
{
    public $layout = '//layouts/new/main';

    public function filters()
    {
        return array(
            'ajaxOnly + readOne,readAll,unread',
            'accessControl'
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'users' => array('@'),
            ),
            array('deny',
                'users' => array('*'),
            ),
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
        $list = Notification::model()->getNotificationsList(Yii::app()->user->id, 0, $page, true);
        //NotificationRead::setReadSummaryNotifications($list);

        if (Yii::app()->request->isAjaxRequest) {
            echo CJSON::encode(array(
                'success' => true,
                'html' => $this->renderPartial('list', array('list' => $list, 'read' => false), true),
                'empty' => empty($list)
            ));
        } else
            $this->render('index_v2', array('list' => $list, 'read' => false));
    }

    public function actionRead($page = 0)
    {
        $this->pageTitle = 'Прочитанные уведомления';

        $list = Notification::model()->getNotificationsList(Yii::app()->user->id, 1, $page);
        if (Yii::app()->request->isAjaxRequest) {
            echo CJSON::encode(array(
                'success' => true,
                'html' => $this->renderPartial('list', array('list' => $list, 'read' => true), true),
                'empty' => empty($list)
            ));
        } else
            $this->render('index', array('list' => $list, 'read' => true));
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