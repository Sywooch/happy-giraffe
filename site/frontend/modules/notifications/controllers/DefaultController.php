<?php

namespace site\frontend\modules\notifications\controllers;

use site\frontend\modules\notifications\models\Notification;

class DefaultController extends \HController
{
    public $layout = '//layouts/new/main';
    public $bodyClass = 'body__bg-base';
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
        $this->pageTitle = !$read ? 'Новые сигналы' : 'Архив';
        $list = Notification::model()
            ->byUser(\Yii::app()->user->id)
            ->byRead($read)
            ->earlier($lastNotificationUpdate)
            ->orderByDate()
            ->limit(self::PAGE_SIZE)
            ->findAll();
        $unreadCount = Notification::getUnreadCount();

        if (\Yii::app()->request->isAjaxRequest)
        {
            echo \HJSON::encode(array('list' => $list, 'read' => $read));
        }
        else
            $this->render('index_v2', array('list' => $list, 'read' => $read, 'unreadCount' => $unreadCount));
    }

    public function actionRead()
    {
        $events = \Yii::app()->request->getPost('events', array());
        $events = array_map(function($event)
            {
                return new \MongoId($event);
            }, $events);
        $notifications = Notification::model()->byUser(\Yii::app()->user->id)->findAllByPk($events);
        foreach ($notifications as $notification)
        {
            $notification->readAll();
            $notification->save();
       }

        echo \CJSON::encode(array('success' => true));
    }

    public function actionReadAll()
    {

    }

}