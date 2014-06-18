<?php

namespace site\frontend\modules\notifications\controllers;

class DefaultController extends \HController
{

    public $layout = '//layouts/new/main';
    
    public $notifyClass = '\site\frontend\modules\notifications\models\Notification';

    const PAGE_SIZE = 20;

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
        \Yii::import('site.frontend.modules.routes.models.*');
        parent::init();
    }

    public function actionIndex($read = 0, $lastNotificationUpdate = false)
    {
        $this->pageTitle = $read ? 'Новые уведомления' : 'Прочитанные уведомления';
        $list = array();

        if (\Yii::app()->request->isAjaxRequest)
        {
            echo \HJSON::encode(array('list' => $list, 'read' => $read), $this->JSONConfig);
        }
        else
            $this->render('index_v2', array('list' => $list, 'read' => $read, 'unreadCount' => 0));
    }

    public function actionRead()
    {

    }

    public function actionReadAll()
    {

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