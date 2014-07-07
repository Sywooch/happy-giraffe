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
        $this->pageTitle = !$read ? 'Новые сигналы' : 'Архив';
        $list = \site\frontend\modules\notifications\models\Notification::model()
            ->byUser(\Yii::app()->user->id)
            ->byRead($read)
            ->earlier($lastNotificationUpdate)
            ->orderByDate()
            ->limit(self::PAGE_SIZE)
            ->findAll();
        $unreadCount = \site\frontend\modules\notifications\models\Notification::getUnreadCount();
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
        $notifications = \site\frontend\modules\notifications\models\Notification::model()->byUser(\Yii::app()->user->id)->findAllByPk($events);
        $comet = new \CometModel();
        foreach ($notifications as $notification)
        {
            $notification->readAll();
            $notification->save();

            // отправим событие о прочтении
            $comet->send(\Yii::app()->user->id, array('notification' => array('id' => (string) $notification->_id)), \CometModel::NOTIFY_READED);
        }

        echo \CJSON::encode(array('success' => true));
    }

    public function actionReadAll()
    {
        
    }

}