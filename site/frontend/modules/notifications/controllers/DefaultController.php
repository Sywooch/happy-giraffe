<?php

class DefaultController extends HController
{

    public $layout = '//layouts/new/main';

    public function filters()
    {
        return array(
            'ajaxOnly + read,readAll',
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
        $list = Notification::model()->getNotificationsList(Yii::app()->user->id, (int) $read, (int) $lastNotificationUpdate, true);
        //NotificationRead::setReadSummaryNotifications($list);

        if (Yii::app()->request->isAjaxRequest)
        {
            echo HJSON::encode(array('list' => $list, 'read' => $read), $this->JSONConfig);
        }
        else
            $this->render('index_v2', array('list' => $list, 'read' => $read, 'unreadCount' => Notification::model()->getUnreadCount()));
    }

    public function actionRead()
    {
        $notifications = Notification::model()->findAllByPk(Yii::app()->request->getPost('events', array()));
        $comet = new CometModel();
        echo CJSON::encode(array('success' => true));
        foreach ($notifications as $notification)
        {
            if ($notification->recipient_id == Yii::app()->user->id)
            {
                $notification->setRead();
                $comet->send(Yii::app()->user->id, array('notification' => array('id' => (string)$notification->id)), CometModel::NOTIFY_READED);
            }
        }
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
                '(int)id',
                'author' => $authorConfig,
                'created',
                'title',
                'powerTipTitle',
                'previewUrl',
                'contentTitle',
                'url',
            ),
            'CModel' => array(
                '(int)id',
                'author' => $authorConfig,
                'created',
                'title',
                '(int)type_id',
                'powerTipTitle',
                'contentTitle',
                'url',
        ));
        return array(
            'NotificationSummary' => array(
                "(string)id",
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
                "(string)id",
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
                "(string)id",
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
                "(string)id",
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