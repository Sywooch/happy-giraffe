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

    public function actionIndex($read = 0, $lastNotificationUpdate = false)
    {
        $this->pageTitle = $read ? 'Новые уведомления' : 'Прочитанные уведомления';
        $list = Notification::model()->getNotificationsList(Yii::app()->user->id, (int)$read, (int)$lastNotificationUpdate, true);
        //NotificationRead::setReadSummaryNotifications($list);

        if (Yii::app()->request->isAjaxRequest)
        {
            echo HJSON::encode(array('list' => $list, 'read' => $read), $this->JSONConfig);
        }
        else
            $this->render('index_v2', array('list' => $list, 'read' => $read));
    }

    public function actionRead($page = 0)
    {
        $this->pageTitle = 'Прочитанные уведомления';

        $list = Notification::model()->getNotificationsList(Yii::app()->user->id, 1, $page);
        if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'success' => true,
                'html' => $this->renderPartial('list', array('list' => $list, 'read' => true), true),
                'empty' => empty($list)
            ));
        }
        else
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

    public function getJSONConfig()
    {
        $authorConfig = array(
            'User' => array(
                '(int)id',
                'avaOrDefaultImage',
                '(int)online',
                'url',
            ),
        );
        $contentConfig = array(
            'AlbumPhoto' => array(
                'id',
                'author' => $authorConfig,
                'created',
                'title',
                'powerTipTitle',
                'contentTitle',
            ),
            'CModel' => array(
                'id',
                'author' => $authorConfig,
                'created',
                'title',
                'type_id',
                'powerTipTitle',
                'contentTitle',
        ));
        return array(
            'NotificationSummary' => array(
                "type",
                "updated",
                "count",
                "visibleCount",
                "read",
                "articles" => array(
                    'NotificationArticle' => array(
                        'entity',
                        'entity_id',
                        'count',
                        'model' => $contentConfig,
                    )
                ),
            ),
            'NotificationUserContentComment' => array(
                "type",
                "entity",
                "entity_id",
                "updated",
                "count",
                "visibleCount",
                "url",
                "read",
                "relatedModel" => $contentConfig,
                'comments' => array(
                    'Comment' => array(
                        'text',
                        'author' => $authorConfig,
                    )
                ),
            ),
            'NotificationGroup' => array(
                "type",
                "entity",
                "entity_id",
                "updated",
                "count",
                "visibleCount",
                "url",
                "read",
                "relatedModel" => $contentConfig,
                'comment' => array(
                    'Comment' => array(
                        'text',
                        'author' => $authorConfig,
                    ),
                ),
                'comments' => array(
                    'Comment' => array(
                        'text',
                        'author' => $authorConfig,
                    )
                ),
            ),
            'Notification' => array(
                "type",
                "entity",
                "entity_id",
                "updated",
                "count",
                "visibleCount",
                "url",
                "read",
                "relatedModel" => $contentConfig,
            ),
        );
    }

}