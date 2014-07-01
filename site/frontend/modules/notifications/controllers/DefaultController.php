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
        $list = \site\frontend\modules\notifications\models\Notification::model()->byUser(\Yii::app()->user->id)->earlier($lastNotificationUpdate)->orderByDate()->limit(self::PAGE_SIZE)->findAll();
        $unreadCount = \site\frontend\modules\notifications\models\Notification::getUnreadCount();
        if (\Yii::app()->request->isAjaxRequest)
        {
            echo \HJSON::encode(array('list' => $list, 'read' => $read), $this->JSONConfig);
        }
        else
            $this->render('index_v2', array('list' => $list, 'read' => $read, 'unreadCount' => $unreadCount));
    }

    public function actionRead()
    {
        
    }

    public function actionReadAll()
    {
        
    }

    public function getJSONConfig()
    {
        $entity = array(
            'tooltip',
            'title',
            'url',
            'type',
        );
        return array(
            'site\frontend\modules\notifications\models\Notification' => array(
                'type',
                'entity' => array(
                    'site\frontend\modules\notifications\models\Entity' => $entity,
                ),
                'unreadCount',
                'unreadEntities' => array(
                    'site\frontend\modules\notifications\models\Entity' => $entity,
                ),
                'unreadAvatars',
                'readCount',
                'readEntities' => array(
                    'site\frontend\modules\notifications\models\Entity' => $entity,
                ),
                'readAvatars',
                'dtimeUpdate',
            ),
        );
    }

}