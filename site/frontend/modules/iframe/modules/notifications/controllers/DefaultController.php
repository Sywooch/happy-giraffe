<?php

namespace site\frontend\modules\iframe\modules\notifications\controllers;

use site\frontend\modules\iframe\modules\notifications\models\Notification;

class DefaultController extends \HController
{
    public $layout = '/../../../views/layouts/notification';
    public $litePackage = 'pediatrician-iframe';
    public $bodyClass = 'body__bg-base page-iframe--bg';
    public $notifyClass = '\site\frontend\modules\iframe\modules\notifications\models\Notification';

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

    public function actionIndex($lastNotificationUpdate = false)
    {
        $this->pageTitle = 'Сигналы';
        $readList = Notification::model()
            ->byUser(\Yii::app()->user->id)
            ->byRead(1)
            ->earlier($lastNotificationUpdate)
            ->orderByDate()
            ->limit(self::PAGE_SIZE)
            ->findAll();
        $unreadList = Notification::model()
            ->byUser(\Yii::app()->user->id)
            ->byRead(0)
            ->earlier($lastNotificationUpdate)
            ->orderByDate()
            ->limit(self::PAGE_SIZE)
            ->findAll();
        $readCount = Notification::getReadSum();
        $unreadCount = Notification::getUnreadSum();

        $this->render('index_iframe', [
            'readList' => $readList,
            'unreadList' => $unreadList,
            'unreadCount' => $unreadCount,
            'readCount' => $readCount,
        ]);
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